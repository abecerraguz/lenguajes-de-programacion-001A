# 🎓 Guión de Clase — Semana 6
## "Aplicando las acciones básicas para gestión de datos (CRUD)"
### Carrera: Desarrollo y Diseño Web · Duración: 1h 30 min

---

> **Antes de comenzar la clase:**
> - Tener XAMPP corriendo (Apache + MySQL)
> - CMS-nuevo cargado en `htdocs/cms-nuevo` con la BD `mi_blog` importada
> - Tener abierto VS Code con los archivos del admin
> - Tener el navegador en `http://localhost/cms-nuevo/admin`
> - Usuario demo: `admin` / contraseña: `admin`

---

## 🟢 BLOQUE 1 — Introducción y concepto CRUD
### ⏱️ Tiempo: 15 minutos

---

### [00:00 — 00:05] Bienvenida y contexto

**Di a los estudiantes:**

> "La semana pasada lograron conectar su CMS a la base de datos y mostraron artículos en la página de inicio. Eso fue la 'R' de CRUD: **leer** información.
>
> Hoy vamos a completar el ciclo. Cuando ustedes usan Instagram, Facebook, o cualquier red social, hay alguien que sube una foto (**crear**), la edita (**actualizar**) o la borra (**eliminar**). Eso es exactamente lo que vamos a programar hoy para su CMS."

---

### [00:05 — 00:15] Explicación del concepto CRUD

**Escribe en la pizarra o muestra esta tabla:**

```
C → CREATE  (Crear)     → INSERT INTO   → Agregar un artículo nuevo
R → READ    (Leer)      → SELECT        → Ver el listado de artículos
U → UPDATE  (Actualizar)→ UPDATE        → Editar un artículo existente
D → DELETE  (Eliminar)  → DELETE        → Borrar un artículo
```

**Di a los estudiantes:**

> "Estas 4 letras representan TODO lo que se puede hacer con datos en una base de datos. No hay más operaciones. Cada aplicación que conocen — Gmail, Mercado Libre, el portal de Duoc — hace estas mismas 4 cosas con sus datos."

**Preguntas activadoras (espera respuestas del curso):**

- *"¿Qué operación CRUD ocurre cuando publican una historia en Instagram?"* → CREATE
- *"¿Y cuando editan la descripción de su perfil?"* → UPDATE
- *"¿Y cuando archivan un mensaje?"* → DELETE
- *"¿Y cuando abren su feed y ven las publicaciones?"* → READ

**Di a los estudiantes:**

> "En su CMS, van a necesitar una zona especial donde solo el administrador pueda hacer estas operaciones. No el visitante del sitio — solo el dueño del contenido. A eso le llamamos **zona de administración o panel admin**."

---

## 🔵 BLOQUE 2 — La zona de administración y la estructura del proyecto
### ⏱️ Tiempo: 15 minutos (acumulado: 30 min)

---

### [00:15 — 00:25] Mostrar la demo del CMS-nuevo

**Abre el navegador en `http://localhost/cms-nuevo/admin` y muestra:**

> "Este es el panel de administración de mi demo. Tiene login, muestra estadísticas, lista de artículos... Es más completo que lo que ustedes deben entregar, pero sirve para entender hacia dónde vamos."

**Navega por estas pantallas mientras describes:**

1. **Login** → *"El sistema pide usuario y contraseña antes de entrar. Para la entrega de ustedes esto es opcional, pero es una buena práctica."*
2. **Listado (admin_list.php)** → *"Esta es la página principal del admin. Muestra todos los artículos con botones para editar y borrar. Esta es la operación **READ** del CRUD."*
3. **Nueva publicación (admin_insertar.php)** → *"Aquí ingresamos datos nuevos. Este formulario, al enviarse, ejecuta un **INSERT INTO** en la base de datos. Esto es el **CREATE**."*
4. **Editar (admin_editar.php)** → *"Aquí modificamos un artículo que ya existe. El botón guardar ejecuta un **UPDATE**. Esto es el **UPDATE**."*
5. **Botón eliminar** → *"Este botón ejecuta un **DELETE**. Fíjense que pide confirmación antes de borrar, porque esta acción no se puede deshacer."*

**Di a los estudiantes:**

> "Mi demo usa 5 tablas relacionadas: artículos, usuarios, categorías, etiquetas, y una tabla que conecta artículos con etiquetas.
>
> Para la nota de ustedes, con 2 tablas está perfecto. La lógica es exactamente la misma — solo con menos campos."

---

### [00:25 — 00:30] Estructura de archivos del admin

**Abre VS Code y muestra la carpeta `admin/` del cms-nuevo:**

```
admin/
├── admin_list.php      ← Muestra el listado (READ)
├── admin_insertar.php  ← Formulario para crear (CREATE - Vista)
├── new-post.php        ← Procesa el formulario y hace el INSERT
├── admin_editar.php    ← Formulario para editar (UPDATE - Vista)
├── edit-post.php       ← Procesa el formulario y hace el UPDATE
└── delete-post.php     ← Ejecuta el DELETE
```

**Di a los estudiantes:**

> "Fíjense que hay dos archivos por operación: uno que **muestra el formulario** y otro que **procesa los datos**. Esto es una buena práctica. El material del curso usa un solo archivo para simplificar, y eso también funciona perfectamente para lo que necesitan entregar."

---

## 🟡 BLOQUE 3 — READ: Mostrar el listado (admin_listado.php)
### ⏱️ Tiempo: 15 minutos (acumulado: 45 min)

---

### [00:30 — 00:45] Código del listado con explicación línea a línea

**Abre `admin/admin_list.php` en VS Code. Muestra solo la parte del PHP al inicio y la tabla:**

**Di a los estudiantes:**

> "Vamos a la parte más simple: leer y mostrar artículos. Este es el flujo completo:"

**Dibuja en la pizarra:**
```
Navegador → PHP pregunta a MySQL → MySQL devuelve datos → PHP los muestra en HTML
```

**Señala estas líneas del código mientras las explicas:**

```php
// 1. Incluir los archivos de conexión
include_once('auth.php');          // Verifica que el usuario haya hecho login
include_once('../class/config.php'); // Las credenciales de la BD
include_once('../class/db.php');     // La clase que habla con MySQL

// 2. Conectar y consultar
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$db->query('SELECT a_id, a_titulo, a_fecha FROM cms_articulos ORDER BY a_fecha DESC');
$articulos = $db->fetchAll();   // Guarda TODOS los resultados en el array $articulos
$db->close();
```

**Di a los estudiantes:**

> "Para la versión simple del material del curso, sin la clase `db`, el código es así:"

```php
// Versión del material del curso (sin clase db, más directa)
$conexion = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$resultado = $conexion->query("SELECT a_id, a_titulo FROM cms_articulos");
$articulos = $resultado->fetch_all(MYSQLI_ASSOC);
$conexion->close();
```

**Luego señala el foreach en el HTML:**

```php
<?php foreach ($articulos as $articulo): ?>
    <tr>
        <td><?php echo $articulo["a_id"]; ?></td>
        <td><?php echo $articulo["a_titulo"]; ?></td>
        <td>
            <a href="admin_editar.php?id=<?= $articulo['a_id'] ?>">Editar</a>
        </td>
    </tr>
<?php endforeach; ?>
```

**Di a los estudiantes:**

> "El `foreach` es como un mesero que va a la cocina (la base de datos), trae todos los platos (artículos), y los pone en la mesa (la tabla HTML) uno por uno.
>
> Fíjense en el `?id=` en el enlace de Editar. Así le pasamos al siguiente archivo **qué artículo** queremos editar."

---

## 🟠 BLOQUE 4 — CREATE: Insertar un artículo (admin_insertar.php)
### ⏱️ Tiempo: 20 minutos (acumulado: 1h 05 min)

---

### [00:45 — 01:05] Formulario + proceso de inserción

**Abre `admin/admin_insertar.php` en VS Code. Muestra el formulario HTML:**

**Di a los estudiantes:**

> "Este archivo tiene dos partes: el formulario HTML que el usuario ve, y el código PHP que procesa los datos cuando hace clic en 'Guardar'."

**Explica el formulario:**

```html
<form action="new-post.php" method="post">
    <input type="text"     name="title"    placeholder="Título">
    <textarea              name="excerpt"  placeholder="Resumen"></textarea>
    <textarea              name="content"  placeholder="Contenido"></textarea>
    <button type="submit">Guardar</button>
</form>
```

**Di a los estudiantes:**

> "El atributo `name` de cada campo es clave. Es como etiquetar una caja antes de enviarla. El servidor recibe esa caja y la abre buscando la etiqueta `name`."

> "El `method='post'` significa que los datos viajan en las 'cabeceras' de la petición — no aparecen en la URL. Úsenlo siempre para formularios que envían datos."

**Ahora muestra el procesador `new-post.php` (o la versión simplificada del material):**

**Di a los estudiantes:**

> "Cuando el usuario hace clic en 'Guardar', el navegador envía los datos a este archivo. El flujo es:"

**Dibuja en la pizarra:**
```
Usuario llena formulario → hace clic Guardar
→ PHP recibe $_POST['title'], $_POST['excerpt']...
→ PHP arma la consulta SQL
→ MySQL inserta el nuevo registro
→ PHP redirige al listado
```

**Muestra el código de inserción simplificado:**

```php
// 1. Verificar que llegaron datos
if (isset($_POST['title']) && $_POST['title'] != "") {

    // 2. Guardar los datos del formulario en variables
    $titulo  = $_POST['title'];
    $resumen = $_POST['excerpt'];
    $texto   = $_POST['content'];
    $autor   = 1;  // Por ahora lo dejamos fijo

    // 3. Armar la consulta SQL de inserción
    $query = "INSERT INTO cms_articulos 
              (a_titulo, a_resumen, a_texto, a_autor, a_fecha) 
              VALUES ('$titulo', '$resumen', '$texto', $autor, NOW())";

    // 4. Ejecutar la consulta
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    $db->query($query);

    // 5. Redirigir al listado
    header("Location: admin_listado.php");
    exit;
}
```

**Di a los estudiantes:**

> "`NOW()` es una función de MySQL que inserta automáticamente la fecha y hora actual del servidor. Mucho más simple que pasar la fecha desde PHP."

> "El `header('Location:...')` redirige al usuario a otra página. El `exit` después es importante — le dice a PHP que pare de ejecutar código."

**🔴 PAUSA IMPORTANTE — muestra en el navegador:**

> "Vamos a probar en vivo. Abro `admin_insertar.php`, lleno el formulario con un artículo de prueba, y hacemos clic en Guardar."

*[Demostrar en pantalla: llenar formulario → guardar → ver que aparece en el listado]*

> "¿Ven? El artículo apareció en el listado. PHP tomó lo que escribimos, hizo un INSERT en MySQL, y nos redirigió. Eso es el **CREATE** funcionando."

---

## 🔴 BLOQUE 5 — UPDATE: Editar un artículo (admin_editar.php)
### ⏱️ Tiempo: 15 minutos (acumulado: 1h 20 min)

---

### [01:05 — 01:20] Editar un artículo existente

**Di a los estudiantes:**

> "Editar es muy parecido a insertar, pero con dos diferencias clave:
> 1. Primero tenemos que **leer** el artículo actual y mostrarlo en el formulario
> 2. En vez de `INSERT INTO`, usamos `UPDATE ... WHERE a_id = ?`"

**Muestra el código de carga del artículo en `admin_editar.php`:**

```php
// Recibimos el ID del artículo desde la URL (?id=1)
$idArticulo = (int)$_GET['id'];

// Buscamos ese artículo en la BD
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$db->query('SELECT * FROM cms_articulos WHERE a_id = ?', $idArticulo);
$articulo = $db->fetchArray();  // fetchArray trae solo UNA fila
```

**Muestra cómo se precarga el formulario:**

```html
<!-- El value= muestra el dato actual del artículo -->
<input type="hidden" name="idPost" value="<?= $articulo['a_id'] ?>">
<input type="text"   name="title"  value="<?= htmlspecialchars($articulo['a_titulo']) ?>">
<textarea name="excerpt"><?= htmlspecialchars($articulo['a_resumen']) ?></textarea>
```

**Di a los estudiantes:**

> "El `input type='hidden'` es invisible para el usuario pero viaja con el formulario. Así sabemos el ID del artículo al guardar."

> "`htmlspecialchars()` convierte caracteres como `<` o `>` para que no rompan el HTML. Siempre úsenlo cuando muestran datos de la base de datos."

**Muestra el código de actualización:**

```php
// Al recibir el formulario
if (isset($_POST['title']) && $_POST['title'] != "") {
    $id      = (int)$_POST['idPost'];
    $titulo  = $_POST['title'];
    $resumen = $_POST['excerpt'];
    $texto   = $_POST['content'];

    // UPDATE en vez de INSERT
    $query = "UPDATE cms_articulos 
              SET a_titulo = '$titulo', 
                  a_resumen = '$resumen', 
                  a_texto = '$texto'
              WHERE a_id = $id";

    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
    $db->query($query);
    
    header("Location: admin_listado.php");
    exit;
}
```

**Di a los estudiantes:**

> "La diferencia clave con el INSERT: el `UPDATE` necesita el `WHERE` para decirle a MySQL **cuál** artículo modificar. Sin el `WHERE`, MySQL actualizaría **todos** los artículos con los mismos datos. ¡Catástrofe!"

**🔴 DEMOSTRACIÓN en pantalla:**
*[Hacer clic en Editar en un artículo → modificar el título → guardar → ver el cambio en el listado]*

---

### [01:20 — 01:25] DELETE: Eliminar (concepto rápido)

**Di a los estudiantes:**

> "El DELETE es el más corto de todos. Solo necesita el ID del artículo:"

```php
// delete-post.php
$id = (int)$_GET['id'];

$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$db->query("DELETE FROM cms_articulos WHERE a_id = $id");
$db->close();

header("Location: admin_listado.php");
exit;
```

> "En la lista, el botón Eliminar lleva a este archivo pasando el ID: `delete-post.php?id=3`"

> "Importante: en mi demo, antes de borrar aparece una ventana de confirmación. Eso es una buena práctica de usabilidad — nunca eliminen datos sin confirmar con el usuario."

---

## 🟣 BLOQUE 6 — Cierre, resumen y tarea
### ⏱️ Tiempo: 10 minutos (acumulado: 1h 30 min)

---

### [01:20 — 01:30] Resumen final y conexión con la actividad formativa

**Dibuja en la pizarra el resumen completo:**

```
CRUD en tu CMS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
C  CREATE  → admin_insertar.php  → INSERT INTO cms_articulos ...
R  READ    → admin_listado.php   → SELECT * FROM cms_articulos
U  UPDATE  → admin_editar.php    → UPDATE cms_articulos SET ... WHERE a_id = ?
D  DELETE  → (botón + archivo)   → DELETE FROM cms_articulos WHERE a_id = ?
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

**Di a los estudiantes:**

> "Para su actividad formativa deben hacer exactamente esto con **sus propias 2 tablas**. La lógica que vimos hoy es idéntica — solo cambia el nombre de la tabla y los campos.
>
> Los pasos concretos son:
> 1. Crear `admin_listado.php` → conectarse a la BD y mostrar los registros en una tabla
> 2. Crear `admin_insertar.php` → formulario + código de INSERT
> 3. Crear `admin_editar.php` → formulario precargado + código de UPDATE
> 4. Agregar un botón/enlace de eliminar → código de DELETE
> 5. Probar todo y comprimir en `.zip` para subir al AVA"

**Preguntas de reflexión (del material):**

> *"¿Cómo harían para editar un registro distinto al 1? ¿Qué habría que cambiar?"*
→ Pasar el ID por la URL (`?id=X`) y leerlo con `$_GET['id']`

> *"¿Cuál creen que es la consulta SQL para borrar un registro?"*
→ `DELETE FROM cms_articulos WHERE a_id = $id`

---

### Recordatorio de entrega

> "Recuerden que la entrega es un archivo `.zip` con todos sus archivos PHP del admin funcionando. Revisen que estén los 4 archivos correspondientes a cada operación CRUD antes de comprimir."

---

## 📋 Cheat sheet para los estudiantes
*(Para mostrar en pantalla al final o compartir)*

```php
// ── CONECTAR ──────────────────────────────────────
include_once('clases/db.php');
include_once('clases/config.php');
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

// ── READ: Listar todos ────────────────────────────
$db->query("SELECT * FROM mi_tabla");
$registros = $db->fetchAll();
$db->close();
// En el HTML: foreach ($registros as $reg) { echo $reg['campo']; }

// ── CREATE: Insertar ──────────────────────────────
$query = "INSERT INTO mi_tabla (campo1, campo2) VALUES ('$valor1', '$valor2')";
$db->query($query);
header("Location: admin_listado.php"); exit;

// ── READ: Obtener uno para editar ─────────────────
$id = (int)$_GET['id'];
$db->query("SELECT * FROM mi_tabla WHERE id = $id");
$registro = $db->fetchArray();

// ── UPDATE: Actualizar ────────────────────────────
$id = (int)$_POST['txtID'];
$query = "UPDATE mi_tabla SET campo1 = '$valor1' WHERE id = $id";
$db->query($query);
header("Location: admin_listado.php"); exit;

// ── DELETE: Eliminar ──────────────────────────────
$id = (int)$_GET['id'];
$db->query("DELETE FROM mi_tabla WHERE id = $id");
header("Location: admin_listado.php"); exit;
```

---

## ⚠️ Errores comunes — qué vigilar durante la clase

| Error frecuente | Causa | Solución |
|---|---|---|
| La página da error en blanco | PHP no conecta a la BD | Verificar `config.php` con host/user/pass correctos |
| El INSERT no guarda nada | El `name` del input no coincide con `$_POST['...']` | Revisar que los `name` del form y el PHP sean idénticos |
| El UPDATE cambia todos los registros | Falta el `WHERE a_id = $id` | Siempre incluir `WHERE` en UPDATE y DELETE |
| La página no redirige | Falta `exit;` después del `header()` | Agregar `exit;` inmediatamente después |
| Caracteres raros en el texto | Problemas de encoding | Agregar `charset=utf8` en la conexión |

---

*Guión preparado para la clase Semana 6 · Lenguaje de Programación · Duoc UC*
