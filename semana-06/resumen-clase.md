
# Semana 6 – Aplicando las acciones básicas para gestión de datos
![Infografía](material-clase/infografia.png)
> **Experiencia 3 – Semana 6 | Duoc UC**  
> Carrera: Desarrollo y Diseño Web

---

## Introducción

Esta semana se trabaja el concepto de **CRUD** y su implementación en un CMS con PHP y MySQL. Se crea la **zona de administración**, que permite a usuarios autorizados gestionar el contenido de la base de datos sin necesidad de usar phpMyAdmin.

[Descargar presentación](material-clase/presentacion.pdf)
---

## Resultados de Aprendizaje

- **RA1.** Utiliza lenguaje de programación para proponer soluciones creativas para el manejo del contenido dinámico.
- **RA2.** Programa acciones para la interacción, definiendo base de datos vía SQL considerando framework CSS, usabilidad y accesibilidad.

**Indicadores de logro clave:**
- IL1. Variables, arrays, if-else, bucles.
- IL2. Funciones PHP para reutilizar código.
- IL3. Framework CSS (Bootstrap) para la interfaz.
- IL5. Conexión a base de datos y consultas SQL.
- IL6. Recuperar y desplegar información desde la BD.
- **IL7. Programar las acciones CRUD con PHP.**

---

## 1. ¿Qué es CRUD?

CRUD es el acrónimo de las 4 operaciones fundamentales sobre una base de datos:

| Letra | Operación | SQL | Ejemplo |
|-------|-----------|-----|---------|
| **C** | Create (Crear) | `INSERT INTO` | Agregar un artículo nuevo |
| **R** | Read (Leer) | `SELECT` | Mostrar el listado de artículos |
| **U** | Update (Actualizar) | `UPDATE` | Editar título de un artículo |
| **D** | Delete (Eliminar) | `DELETE` | Borrar un artículo |

> CRUD es la base de la **zona de administración** de cualquier CMS.

---

## 2. Zona de Administración del CMS

La zona de administración es accesible **solo por usuarios autorizados** (administradores). Desde allí se realizan todas las operaciones CRUD sobre el contenido almacenado en la base de datos.

**Archivos a crear dentro de la carpeta CMS (htdocs):**
- `admin_listado.php` → Leer / listar artículos (Read)
- `admin_insertar.php` → Crear nuevo artículo (Create)
- `admin_editar.php` → Actualizar artículo existente (Update)

---

## 3. Archivo `admin_listado.php` (Read)

Muestra todos los artículos de la BD en una tabla con columnas: **ID**, **Título** y **Acción** (editar / borrar).

Los datos se obtienen dinámicamente desde la base de datos (campos `a_id` y `a_titulo`).

```php
<body>
  <main class="container">
    <div class="row">
      <div class="col-12">
        <table>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Acción</th>
          </tr>
          <?php
          foreach ($articulos as $articulo) {
          ?>
          <tr>
            <td><?php echo $articulo["a_id"]; ?></td>
            <td><?php echo $articulo["a_titulo"]; ?></td>
            <td></td>
          </tr>
          <?php
          }
          $db->close();
          ?>
        </table>
      </div>
    </div>
  </main>
</body>
```

**Resultado visual:** tabla dinámica con los artículos de la BD, sin necesidad de escribirlos a mano en el HTML.

---

## 4. Archivo `admin_insertar.php` (Create)

### 4.1 El formulario HTML

Se reemplaza el contenido del `<main>` por un formulario que recoge: **Título**, **Fecha**, **Resumen** y **Texto**.  
*(El autor se asigna de forma explícita con el valor `1` en el backend.)*

```html
<main class="container">
  <form>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="txtTitulo">Título</label>
          <input type="text" class="form-control" id="txtTitulo" name="txtTitulo"
                 placeholder="Ingresa un título">
          <small class="form-text text-muted">Sé conciso.</small>
        </div>
        <div class="form-group">
          <label for="txtfecha">Fecha</label>
          <input type="date" class="form-control" id="txtfecha" name="txtfecha">
        </div>
        <div class="form-group">
          <label for="txtResumen">Resumen</label>
          <textarea name="txtResumen" id="txtResumen" cols="30" rows="3"
                    class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="txtTexto">Texto</label>
          <textarea name="txtTexto" id="txtTexto" cols="30" rows="10"
                    class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Grabar</button>
      </div>
    </div>
  </form>
</main>
```

> **Importante:** cada campo debe tener el atributo `name` para que el servidor pueda identificar los datos enviados.

### 4.2 Procesando el formulario (PHP al inicio del archivo)

Al presionar "Grabar", la página se recarga y el código PHP en la parte superior **intercepta** los datos antes de mostrar el HTML.

**Paso 1 – Validar que llegaron datos:**
```php
if (isset($_POST['txtTitulo'])) {
    if ($_POST['txtTitulo'] != "") {
        echo "presionaste el botón";
    }
}
```

**Paso 2 – Capturar variables desde el formulario:**
```php
$titulo  = $_POST['txtTitulo'];
$fecha   = $_POST['txtfecha'];
$resumen = $_POST['txtResumen'];
$texto   = $_POST['txtTexto'];
$autor   = 1; // valor explícito (no viene del formulario)
```

**Paso 3 – Construir la consulta SQL de inserción:**
```php
$query = 'INSERT INTO cms_articulos (a_titulo, a_fecha, a_resumen, a_texto, a_autor)
          VALUES ("' . $titulo . '", NOW(), "' . $resumen . '", "' . $texto . '", ' . $autor . ')';
```

> `NOW()` inserta automáticamente la fecha y hora del servidor, evitando problemas de formato de fecha entre distintos motores de BD.

**Paso 4 – Ejecutar la inserción y redirigir:**
```php
$db     = new db($dbhost, $dbuser, $dbpass, $dbname);
$insert = $db->query($query);
header("Location: admin_listado.php");
```

### 4.3 Código completo del bloque PHP (inicio de `admin_insertar.php`)

```php
<?php
include_once('clases/db.php');
include_once('clases/config.php');

if (isset($_POST['txtTitulo'])) {
    if ($_POST['txtTitulo'] != "") {
        $titulo  = $_POST['txtTitulo'];
        $fecha   = $_POST['txtfecha'];
        $resumen = $_POST['txtResumen'];
        $texto   = $_POST['txtTexto'];
        $autor   = 1;

        $query = 'INSERT INTO cms_articulos (a_titulo, a_fecha, a_resumen, a_texto, a_autor)
                  VALUES ("' . $titulo . '", NOW(), "' . $resumen . '", "' . $texto . '", ' . $autor . ')';

        $db     = new db($dbhost, $dbuser, $dbpass, $dbname);
        $insert = $db->query($query);

        header("Location: admin_listado.php");
    }
}
?>
```

---

## 5. Archivo `admin_editar.php` (Update)

Se crea copiando `admin_insertar.php` y aplicando los siguientes cambios.

### 5.1 Agregar el campo ID al formulario

```html
<form method="post" action="admin_editar.php">
  <div class="form-group">
    <label for="txtID">ID</label>
    <input type="text" class="form-control" id="txtID" name="txtID">
  </div>
  <div class="form-group">
    <label for="txtTitulo">Título</label>
    <input type="text" class="form-control" id="txtTitulo" name="txtTitulo"
           placeholder="Ingresa un título">
    <small class="form-text text-muted">Sé conciso.</small>
  </div>
  <!-- ... resto de campos ... -->
</form>
```

### 5.2 Precargar el registro desde la BD (fuera de los `if`)

El código de precarga se ejecuta **siempre que carga la página**, independiente de si se está editando:

```php
<?php
include_once('clases/db.php');
include_once('clases/config.php');

$idArticulo = 1; // ID del artículo a precargar

$db       = new db($dbhost, $dbuser, $dbpass, $dbname);
$articulo = $db->query('SELECT * FROM cms_articulos WHERE a_id = ' . $idArticulo)->fetchAll();

if (isset($_POST['txtTitulo'])) {
    if ($_POST['txtTitulo'] != "") {
        // lógica de actualización...
    }
}
?>
```

### 5.3 Mostrar los valores del registro en los campos del formulario

```html
<input type="text" class="form-control" id="txtID" name="txtID"
       value="<?php echo $articulo[0]["a_id"]; ?>">

<input type="text" class="form-control" id="txtTitulo" name="txtTitulo"
       value="<?php echo $articulo[0]["a_titulo"]; ?>">

<textarea name="txtResumen" cols="30" rows="3" class="form-control">
  <?php echo $articulo[0]["a_resumen"]; ?>
</textarea>

<textarea name="txtTexto" cols="30" rows="10" class="form-control">
  <?php echo $articulo[0]["a_texto"]; ?>
</textarea>
```

> Se accede al primer elemento del array con `$articulo[0]` y se indica el nombre del campo de la BD.

### 5.4 Lógica de actualización (UPDATE)

```php
if (isset($_POST['txtTitulo'])) {
    if ($_POST['txtTitulo'] != "") {
        $id      = $_POST['txtID'];
        $titulo  = $_POST['txtTitulo'];
        $resumen = $_POST['txtResumen'];
        $texto   = $_POST['txtTexto'];
        $autor   = 1;

        $query = 'UPDATE cms_articulos
                  SET a_titulo = "' . $titulo . '",
                      a_resumen = "' . $resumen . '",
                      a_texto = "' . $texto . '"
                  WHERE a_id = ' . $id;

        $db     = new db($dbhost, $dbuser, $dbpass, $dbname);
        $update = $db->query($query);

        header("Location: admin_listado.php");
    }
}
```

> La diferencia clave con la inserción: se usa `UPDATE ... SET ... WHERE a_id = $id` en lugar de `INSERT INTO`.

---

## 6. GET vs POST en el contexto del CMS

| Situación | Método | Por qué |
|-----------|--------|---------|
| Abrir `admin_listado.php` | GET | Solo se pide/ver información |
| Abrir `admin_insertar.php` | GET | Solo muestra el formulario vacío |
| Enviar formulario de inserción | POST | Guarda datos en la BD (INSERT) |
| Enviar formulario de edición | POST | Modifica datos en la BD (UPDATE) |
| Abrir `admin_editar.php?id=5` | GET | Solo muestra la pantalla de edición |

> **Regla mnemotécnica:** GET = VER / POST = HACER (algo que cambia la BD).

---

## 7. Diagrama del flujo CRUD

```
[admin_listado.php]  ← listado de artículos (SELECT)
       |
       |-- click "Nuevo" ────────────────────────────────────────────────┐
       |                                                                  v
       |                                                   [admin_insertar.php]
       |                                                   (form → POST → INSERT)
       |                                                                  |
       |-- click "Editar" ────────────────────────────────┐              |
       |                                                   v              |
       |                                          [admin_editar.php]      |
       |                                          (form → POST → UPDATE)  |
       |                                                   |              |
       └───────────────── redirige a admin_listado.php ───────────────────┘
```

---

## 8. Preguntas de reflexión (material oficial)

1. ¿Cómo harías para editar un **registro distinto** al que está hardcodeado?
2. ¿Cuál es la consulta SQL para **borrar** un registro?

---

## 9. Glosario

| Término | Definición |
|---------|------------|
| **CRUD** | Create, Read, Update, Delete — operaciones básicas sobre una BD |
| **`$_POST`** | Superglobal PHP con datos enviados por formulario (método POST) |
| **`$_GET`** | Superglobal PHP con datos enviados por URL |
| **`isset()`** | Verifica si una variable existe y no es `null` |
| **`header()`** | Envía una cabecera HTTP; se usa para redirigir páginas |
| **`NOW()`** | Función MySQL que inserta la fecha y hora actuales del servidor |
| **`fetchAll()`** | Método de la clase `db` que retorna todos los registros de una consulta |
| **Zona de administración** | Área privada del CMS donde los administradores gestionan contenidos |
