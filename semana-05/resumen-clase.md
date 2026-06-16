![Infografía](material-clase/infografia.png)
# Semana 5: Desplegando el contenido de una base de datos con PHP

---

## Arquitectura de 3 capas en un CMS

Un CMS (Sistema de Gestión de Contenidos) se organiza en tres capas con responsabilidades distintas:

| Capa | ¿Qué hace? |
|---|---|
| **Capa de Presentación** | Interfaz con la que interactúa el usuario (HTML, CSS, JS). |
| **Capa de Lógica de Negocios** | Procesa la información y aplica las reglas del negocio. |
| **Capa de Acceso a Datos** | Obtiene y envía información desde y hacia la base de datos (SQL). |

[Descargar presentación](material-clase/presentacion.pdf)

---

## ¿Qué es una Clase en PHP?

Una **clase** es un plano o plantilla que define las propiedades (atributos) y comportamientos (métodos) de un objeto. Es la estructura base de la **Programación Orientada a Objetos (POO)**.

> En el CMS, la clase `db` es el "motor" de la **capa de acceso a datos**: encapsula toda la lógica de conexión y consulta a MySQL.

### Componentes principales de una clase

1. **Propiedades** — variables que describen las características del objeto.
2. **Métodos** — funciones que definen el comportamiento del objeto.
3. **Constructor** (`__construct`) — método especial que se ejecuta al crear una instancia.
4. **Visibilidad** — controla el acceso a propiedades y métodos:
   - `public`: accesible desde cualquier lugar.
   - `protected`: accesible desde la clase y sus clases hijas.
   - `private`: accesible solo dentro de la misma clase.

### Ejemplo básico de una clase en PHP

```php
class Persona {
    // Propiedades
    public $nombre;
    public $edad;

    // Constructor
    public function __construct($nombre, $edad) {
        $this->nombre = $nombre;
        $this->edad   = $edad;
    }

    // Método
    public function saludar() {
        return "Hola, soy " . $this->nombre . " y tengo " . $this->edad . " años.";
    }
}

// Crear un objeto (instancia) de la clase
$persona = new Persona("Juan", 30);
echo $persona->saludar(); // Hola, soy Juan y tengo 30 años.
```

---

## Crear la capa de acceso a datos

### Estructura de archivos

```
CMS/
├── index.php
├── assets/
└── clases/
    ├── config.php   ← credenciales de la BD
    └── db.php       ← clase que gestiona la conexión y consultas
```

### El archivo `config.php`

Centraliza las credenciales de conexión. Usar PHP (en vez de JSON o XML) impide que el navegador descargue el archivo, aumentando la seguridad.

```php
<?php
$dbhost = 'localhost';
$dbuser = 'nombre_usuario';
$dbpass = 'clave_usuario';
$dbname = 'nombre_base_datos';
?>
```

### El archivo `db.php` — La clase `db`

Define la clase que encapsula todas las operaciones con MySQL (consultar, insertar, actualizar, eliminar).

```php
<?php
class db{
    // Declaración de variables
    protected $connection;
    protected $query;
    protected $show_errors  = TRUE;
    protected $query_closed = TRUE;
    public    $query_count  = 0;

    // Constructor: establece la conexión a la BD
    public function __construct($dbhost = 'localhost', $dbuser = 'root',
                                $dbpass = '', $dbname = '', $charset = 'utf8')
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
            $this->error('No se pudo conectar a MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);
    }

    // Recibe una consulta SQL y la ejecuta (admite parámetros para prevenir SQL Injection)
    public function query($query) { /* ... */ return $this; }

    // Devuelve todos los resultados como array de arrays asociativos
    public function fetchAll($callback = null) { /* ... */ }

    // Devuelve un único registro como array asociativo
    public function fetchArray() { /* ... */ }

    // Cierra la conexión
    public function close() { return $this->connection->close(); }

    // Número de registros devueltos
    public function numRows() { /* ... */ }

    // Último ID insertado
    public function lastInsertID() { return $this->connection->insert_id; }

    // Muestra errores
    public function error($error) { if ($this->show_errors) exit($error); }
}
?>
```

> **Clave:** `__construct` recibe `$dbhost`, `$dbuser`, `$dbpass`, `$dbname` con valores por defecto. La línea `new mysqli(...)` crea la conexión real con la BD.

---

## Métodos para incluir archivos en PHP

Al usar `include_once` se cargan `config.php` y `db.php` sin riesgo de incluirlos más de una vez.

| Método | Comportamiento si el archivo no existe |
|---|---|
| `include` | Genera un **Warning** y continúa. |
| `require` | Genera un **Fatal Error** y detiene el script. |
| `include_once` | Como `include`, pero solo lo carga una vez. |
| `require_once` | Como `require`, pero solo lo carga una vez. |

> Usa `include_once` o `require_once` para archivos de configuración y clases, evitando declaraciones duplicadas.

---

## Desplegando información con `index.php`

### 1. Incluir las dependencias y crear la instancia

```php
<?php
include_once('clases/db.php');
include_once('clases/config.php');

// Crear instancia de la clase db (capa de acceso a datos)
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

// Ejecutar consulta y obtener resultados
$articulos = $db->query('SELECT * FROM cms_articulos')->fetchAll();
?>
```

### 2. Estructura HTML base

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi sitio</title>
</head>
<body>
    <header>
        <h1>Mi sitio</h1>
    </header>
    <main>
        <!-- aquí va el bucle foreach -->
    </main>
    <footer>
        <p>@2025 - todos los derechos reservados</p>
    </footer>
</body>
</html>
```

### 3. Recorrer e imprimir los resultados

```php
<?php foreach ($articulos as $articulo) { ?>
    <p>
        ID: <?php echo $articulo["a_id"]; ?>,
        Título: <?php echo $articulo["a_titulo"]; ?>
    </p>
<?php } ?>
```

---

## Mejorar la presentación con Bootstrap

### Agregar Bootstrap al `<head>`

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJ10CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous">
```

### Mostrar artículos como tarjetas Bootstrap

```php
<main class="container">
    <div class="row">
        <?php foreach ($articulos as $articulo) { ?>
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $articulo["a_titulo"]; ?>
                        </h5>
                        <p class="card-text">Por:
                            <?php echo $articulo["u_nombre"]; ?>
                        </p>
                        <p class="card-text">
                            <?php echo $articulo["a_resumen"]; ?>
                        </p>
                        <p class="card-text">Fecha de publicación:
                            <?php echo $articulo["a_fecha"]; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php }
        // Cerrar la conexión
        $db->close(); ?>
    </div>
</main>
```

### Usar JOIN para obtener el nombre del autor

Cuando `a_autor` guarda el ID del usuario (no su nombre), se usa `INNER JOIN`:

```php
$articulos = $db->query(
    'SELECT a_id, a_titulo, a_autor, a_resumen, a_fecha, u_nombre
     FROM cms_articulos
     INNER JOIN cms_usuarios ON cms_usuarios.u_id = cms_articulos.a_autor'
)->fetchAll();
```

> **Importante:** reemplazar `SELECT *` por los campos específicos evita ambigüedades cuando dos tablas tienen columnas con el mismo nombre.

---

## Preguntas de reflexión

- ¿Cómo mostrarías la fecha **sin** incluir la hora?
- ¿Cómo mostrarías la fecha en formato **día/mes/año** (español)?
- ¿Qué mejoras visuales agregarías al despliegue con Bootstrap?