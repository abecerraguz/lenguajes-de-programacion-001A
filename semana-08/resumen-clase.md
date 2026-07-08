# Semana 8 — Seguridad básica del CMS: sesiones, login y protección de datos
![Infografía](material-clase/infografia.png)
> **Experiencia 3 – Semana 8:** Utilizando PHP para interactuar con la base de datos y restringir accesos.

Esta semana completamos nuestro CMS haciendo que el **área de administración sea privada**: solo los usuarios autorizados podrán entrar. Para lograrlo vamos a combinar cuatro piezas:

1. **Variables de sesión** — para "recordar" quién inició sesión mientras navega.
2. **`login.php`** — la puerta de entrada con usuario y contraseña.
3. **`seguridad.php`** — el guardia que revisa cada página de administración.
4. **Sanitización de datos** — para protegernos de la inyección de SQL.

Y muy importante: guardaremos las contraseñas de forma segura con **`password_hash()`** y **`password_verify()`**, que es el método correcto y actual en PHP.

[Descargar presentación](material-clase/presentacion.pdf)
---

## 1. ¿Por qué proteger las contraseñas? (hashing)

- **Nunca** debes guardar contraseñas en texto plano en tu base de datos.
- Un **hash** es una versión cifrada y **unidireccional** de la contraseña: **no se puede revertir** a su valor original.
- Piensa en Instagram: si alguien robara su base de datos, no vería tu clave real, solo un texto ilegible. Eso es un hash.

> **Nota sobre el material oficial:** la guía de esta semana muestra el ejemplo con `md5()`. Sirve para entender la idea, pero **MD5 hoy se considera inseguro** (es vulnerable a fuerza bruta y colisiones). En nuestro proyecto usaremos el método recomendado por PHP: **`password_hash()` y `password_verify()`**, que además gestionan el *salt* automáticamente.

### `password_hash()`

```php
$password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
```

- **¿Qué hace?**
  - Toma una contraseña en texto plano (ej. `"miclave123"`).
  - Genera un **hash seguro** usando el algoritmo recomendado por PHP (`PASSWORD_DEFAULT`).
  - Añade automáticamente un **salt** (valor aleatorio): dos contraseñas iguales generan hashes **diferentes**.
- **¿Qué devuelve?** Un string largo como:
  ```
  $2y$10$JwqQkZuvz52Qmlp25BeyM.bsk9es5CQOr5HcVfT0qaf5Qd8ZzP6Xm
  ```
- **¿Por qué es seguro?** El salt y la dificultad del algoritmo lo hacen resistente a ataques por fuerza bruta y *rainbow tables*.

### `password_verify()`

```php
if (password_verify($plain_password, $password_hash)) {
    // Contraseña correcta
}
```

- Compara la contraseña en texto plano con el hash almacenado.
- Devuelve `true` si coinciden, `false` si no.
- El salt lo gestiona automáticamente a partir del hash guardado.

### Resumen visual

- `password_hash()` → **Texto plano** → **Hash seguro** (se guarda en la BD)
- `password_verify()` → **Texto plano + Hash guardado** → **true/false** (para el login)

### Reglas de oro

- Nunca compares contraseñas con `==` ni dentro de la consulta SQL: **siempre** usa `password_verify()`.
- Usa siempre `PASSWORD_DEFAULT` para que PHP elija el mejor algoritmo disponible.
- El hash es largo: tu columna debe ser `VARCHAR(255)`.

---

## 2. Preparar la tabla `cms_usuarios`

Para trabajar correctamente con hashes, ajusta tu tabla:

| Cambio | Antes | Después |
|---|---|---|
| Nombre de la columna | `u_password` | `u_password_hash` |
| Tipo de dato | `VARCHAR(20)` | `VARCHAR(255)` |

En phpMyAdmin: pestaña **Estructura** → columna de contraseña → **Cambiar** → actualizar nombre y tipo.

### Función para la clase `db`: migrar contraseñas planas a hash

Agrega esta función a tu clase `db`. Convierte la contraseña de un usuario a su versión cifrada usando **consulta preparada** (¡doble beneficio: seguridad de contraseña + protección contra inyección SQL!):

```php
// Actualiza el hash de la contraseña de un usuario por su ID
function updatePasswordHash($user_id, $plain_password) {
    // Hashear la contraseña
    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

    // Usar consulta preparada para evitar SQL Injection
    $stmt = $this->connection->prepare("UPDATE cms_usuarios SET u_password_hash = ? WHERE u_id = ?");
    if (!$stmt) {
        $this->error('No se puede preparar la declaración de MySQL - ' . $this->connection->error);
        return false;
    }
    $stmt->bind_param('si', $password_hash, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
```

**Cómo usarla** (por ejemplo en un archivo temporal `migrar.php` que luego eliminas):

```php
include_once('../class/config.php');
include_once('../class/db.php');

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

$db->updatePasswordHash(1, 'abecerra123');
```

> ⚠️ Este archivo de migración es de un solo uso: ejecútalo, verifica en phpMyAdmin que la columna quedó con el hash, y **bórralo**. No debe quedar en tu proyecto final.

---

## 3. Sesiones en PHP: ¿cómo "recuerda" el sitio quién soy?

Las **variables de sesión** permiten almacenar y recuperar información de un usuario **a través de múltiples páginas** durante una sesión activa. Es como la pulsera que te ponen al entrar a un evento: te la ponen una vez en la entrada (login) y todos los guardias de las otras puertas la reconocen sin pedirte de nuevo el carnet.

La sesión comienza cuando el usuario accede al sitio y termina cuando cierra el navegador o se agota el tiempo.

### Los 4 pasos para trabajar con sesiones

| Paso | Función / Sintaxis | Dónde va |
|---|---|---|
| 1. Iniciar sesión | `session_start();` | Al comienzo de **cada** página que use sesiones |
| 2. Asignar valor | `$_SESSION['nombre_variable'] = valor;` | Al autenticar (login) |
| 3. Recuperar valor | `$_SESSION['nombre_variable'];` | En cualquier otra página |
| 4. Finalizar sesión | `session_destroy();` | Al cerrar sesión (logout) |

---

## 4. `login.php` — la puerta de entrada

Crea el archivo `login.php` dentro de tu carpeta `CMS` (en `htdocs`). El flujo es:

1. El formulario envía `txtUser` y `txtPass` por **POST** a la misma página.
2. PHP valida que los campos no estén vacíos.
3. Se busca el usuario **por su nombre de usuario** y se verifica la clave con `password_verify()`.
4. Si coincide → se crea `$_SESSION['idUsuario']` y se redirige a `admin_listado.php`.
5. Si no → se destruye la sesión y se muestra un mensaje de error.

### Versión segura (con `password_verify()` y consulta preparada)

> Esta versión reemplaza el `md5()` del material oficial por el método correcto. Fíjate que la consulta **solo busca por username** y la verificación de la clave se hace en PHP.

```php
<?php
session_start();

include_once('clases/db.php');
include_once('clases/config.php');

$username = isset($_POST['txtUser']) ? trim($_POST['txtUser']) : null;
$password = isset($_POST['txtPass']) ? $_POST['txtPass'] : null;
$texto = '';

if (($username != null) && ($password != null)) {
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    // 1. Buscar al usuario SOLO por su nombre de usuario (consulta preparada)
    $stmt = $db->connection->prepare('SELECT u_id, u_password_hash FROM cms_usuarios WHERE u_username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();

    // 2. Verificar la contraseña contra el hash guardado
    if (!empty($usuario) && password_verify($password, $usuario['u_password_hash'])) {
        $_SESSION['idUsuario'] = $usuario['u_id'];
        header("Location: admin_listado.php");
        exit;
    } else {
        session_destroy();
        $texto = '<h2>Usuario o contraseña incorrectos.</h2>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso al CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Mi sitio</h1>
    </header>
    <main class="container">
        <div class="row">
            <div class="col-12">
                <form action="login.php" method="post">
                    <h1>Bienvenido/a. Ingresa tus credenciales</h1>
                    <div class="form-group">
                        <label for="txtUser">usuario</label>
                        <input type="text" class="form-control" id="txtUser" name="txtUser">
                    </div>
                    <div class="form-group">
                        <label for="txtPass">clave</label>
                        <input type="password" class="form-control" id="txtPass" name="txtPass">
                    </div>
                    <?php echo $texto; ?>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>@2026 - todos los derechos reservados</p>
    </footer>
</body>
</html>
```

**Detalles que mejoran la versión del material oficial:**

- `password_verify()` en lugar de `md5()` dentro del SQL → método correcto y actual.
- Consulta **preparada** con `?` y `bind_param` → inmune a inyección SQL en el login.
- `isset()` antes de leer `$_POST` → evita *warnings* cuando la página se carga por primera vez (sin enviar el formulario).
- `<input type="password">` en el campo de clave → oculta lo que se escribe.
- Mensaje de error genérico ("usuario o contraseña incorrectos") → no le regala pistas a un atacante sobre qué usuarios existen.
- `exit;` después de `header("Location: ...")` → detiene la ejecución tras redirigir.

---

## 5. `seguridad.php` — el guardia de las páginas de administración

Crea el archivo `seguridad.php` dentro de la carpeta `clases`. Su trabajo: revisar que exista una sesión válida; si no la hay, expulsar al visitante hacia `login.php`.

```php
<?php
session_start();
$vacio = false;

if (isset($_SESSION) && count($_SESSION) == 0) {
    // sesión vacía
    $vacio = true;
} else {
    if (empty($_SESSION['idUsuario'])) {
        // la sesión específica no tiene valor
        $vacio = true;
    } else {
        if (!is_numeric($_SESSION['idUsuario'])) {
            // no es número
            $vacio = true;
        } else {
            $vacio = false;
        }
    }
}

if ($vacio) {
    header("Location: login.php");
    exit;
}
?>
```

**¿Qué revisa?** Tres situaciones en cascada:
1. Que la sesión no esté completamente vacía.
2. Que exista la variable `idUsuario`.
3. Que `idUsuario` sea un número (un valor manipulado no numérico también expulsa).

### Incrustar el guardia en las páginas de administración

La modificación es **la misma para todas** las páginas de administración. Abre `admin_listado.php` y agrega el llamado a `seguridad.php` **antes** del llamado a `db.php` (la seguridad se verifica antes de conectar con la base de datos):

```php
<?php
include_once('clases/seguridad.php');
include_once('clases/db.php');
include_once('clases/config.php');
```

Repite el mismo proceso en `admin_insertar.php` y `admin_editar.php`.

> ✅ **Prueba rápida:** cierra el navegador (o borra cookies), intenta entrar directo a `admin_listado.php` escribiendo la URL. Si te redirige a `login.php`, tu guardia funciona.

---

## 6. Inyección de SQL: el ataque y las defensas

Los ataques de **inyección de SQL** consisten en que un atacante inserta comandos SQL maliciosos en una consulta (a través de un formulario o de la URL) para obtener acceso no autorizado, alterar contenido o robar información.

### Buenas prácticas para prevenirla

| Práctica | Idea central |
|---|---|
| **Consultas preparadas** (prepared statements) | En vez de concatenar valores en el SQL, se usan marcadores (`?`) que se vinculan de forma segura. PHP las soporta con MySQLi y PDO. Ya la usamos en el login y en `updatePasswordHash()`. |
| **Sanitizar y validar los datos de entrada** | Limpiar caracteres especiales antes de usar datos del usuario en una consulta. |
| **Limitar privilegios de la cuenta de BD** | La cuenta de la aplicación solo debe tener los permisos que realmente necesita. |
| **No exponer mensajes de error detallados** | Los errores detallados dan pistas al atacante; regístralos en logs, no en pantalla. |
| **Mantener el software actualizado** | PHP, MySQL, librerías y frameworks al día corrigen vulnerabilidades conocidas. |

### ¿Dónde sanitizar?

En **todos los puntos donde llega información del usuario**, que se reducen a dos zonas:

- **Campos de formularios** → todo lo que llega por `$_POST` (inserción, edición, login, búsqueda…).
- **Parámetros enviados por URL** → todo lo que llega por `$_GET` (como el `?id=` que implementamos en la Semana 7).

### ¿Cómo sanitizar? (siguiendo la guía oficial)

El material de la semana usa `filter_var()` sobre cada entrada. En `admin_insertar.php`:

```php
$titulo  = filter_var($_POST['txtTitulo'],  FILTER_SANITIZE_STRING);
$fecha   = filter_var($_POST['txtfecha'],   FILTER_SANITIZE_STRING);
$resumen = filter_var($_POST['txtResumen'], FILTER_SANITIZE_STRING);
$texto   = filter_var($_POST['txtTexto'],   FILTER_SANITIZE_STRING);
$autor   = 1;
```

Repite el proceso en `admin_editar.php` (entradas `$_POST` + el id), y en las zonas donde se recibe el id por URL:

```php
// admin_editar.php
$idArticulo = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

// admin_listado.php (id del artículo a borrar)
$idB = filter_var($_GET['idb'], FILTER_SANITIZE_STRING);

// detalle.php
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
```

> 💡 **Dato para tu futuro profesional:** `FILTER_SANITIZE_STRING` está **obsoleto desde PHP 8.1**. Funciona en nuestro entorno de clase, pero en proyectos reales las alternativas correctas son:
> - Para **ids numéricos**: `$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);` o simplemente `(int) $_GET['id']` — si esperas un número, exige un número.
> - Para **texto que se mostrará en HTML**: `htmlspecialchars($_POST['txtTitulo'])`.
> - Y la defensa de fondo, siempre: **consultas preparadas**, que resuelven la inyección SQL de raíz.

---

## 7. Checklist de la semana

- [ ] Tabla `cms_usuarios` creada, con columna `u_password_hash` de tipo `VARCHAR(255)`.
- [ ] Contraseñas guardadas como hash con `password_hash()` (nada de texto plano ni md5).
- [ ] `login.php` creado en la carpeta `CMS`, verificando con `password_verify()`.
- [ ] `seguridad.php` creado en la carpeta `clases`.
- [ ] `include_once('clases/seguridad.php')` agregado **al inicio** de `admin_listado.php`, `admin_insertar.php` y `admin_editar.php` (antes de `db.php`).
- [ ] Entradas `$_POST` sanitizadas en `admin_insertar.php` y `admin_editar.php`.
- [ ] Parámetros `$_GET` sanitizados en `admin_editar.php`, `admin_listado.php` y `detalle.php`.
- [ ] Probado: entrar sin sesión a una página admin redirige a `login.php`.
- [ ] Probado: login con credenciales correctas entra a `admin_listado.php`; con incorrectas muestra el mensaje de error.
- [ ] Archivo de migración de contraseñas eliminado del proyecto.

## 8. Errores comunes y cómo resolverlos

| Error / síntoma | Causa probable | Solución |
|---|---|---|
| `Headers already sent` | Hay HTML o espacios antes de `session_start()` o de `header()` | `session_start()` debe ser lo **primero** del archivo, sin espacios antes de `<?php` |
| Login siempre dice "incorrecto" | La BD aún tiene la clave en texto plano o en md5 | Ejecuta la migración con `updatePasswordHash()` y verifica que la columna sea `VARCHAR(255)` |
| El hash se guarda "cortado" | Columna todavía en `VARCHAR(20)` | Cambia el tipo a `VARCHAR(255)` — un hash cortado nunca va a verificar |
| Redirección infinita a `login.php` | Incluiste `seguridad.php` también en `login.php` | `login.php` **no** lleva el guardia; solo las páginas de administración |
| `Undefined index: txtUser` al abrir login | Se lee `$_POST` sin que el formulario se haya enviado | Usa `isset($_POST['txtUser'])` antes de leer |
| Sigo entrando al admin tras "cerrar sesión" | Falta `session_destroy()` en el logout | Crea un `logout.php` con `session_start(); session_destroy(); header("Location: login.php");` |

---

## Preguntas de reflexión

- ¿Cuál es la importancia de la seguridad en un sitio?
- ¿Qué otras formas de aumentar la seguridad se te ocurren?
- ¿Qué pasaría si los datos de tus usuarios son hackeados?

**¡Con esto tu CMS queda completo y con una capa de seguridad básica! 🔐**

---

*IFD2201 Lenguajes de Programación · DuocUC · Experiencia 3 — Semana 8*
