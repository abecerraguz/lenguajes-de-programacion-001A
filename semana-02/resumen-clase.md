## Semana 2: Introducción a PHP
### Resumen para el Alumno - Preparando las plantillas para un CMS

---

## ¿Qué es PHP?

PHP (Hypertext Preprocessor) es un lenguaje de programación del lado del servidor, diseñado principalmente para el desarrollo web. Permite crear páginas web dinámicas que interactúan con bases de datos.

### Características Principales:
- **Lenguaje interpretado**: No necesita compilación
- **Del lado del servidor**: El código se ejecuta en el servidor y envía HTML al navegador
- **Código abierto**: Es libre y gratuito
- **Multiplataforma**: Funciona en Windows, Linux, macOS
- **Integración con HTML**: Se puede mezclar código PHP dentro de HTML

---

## Sintaxis Básica de PHP

### Estructura de un Archivo PHP
```php
<?php
// Tu código PHP aquí
?>
```

### Hola Mundo en PHP
```php
<?php
echo "¡Hola Mundo!";
?>
```

### Variables en PHP
```php
<?php
$nombre = "Juan";
$edad = 25;
$precio = 19.99;

echo "Hola, $nombre tienes $edad años";
?>
```

### Tipos de Datos
```php
<?php
$texto = "Hola";           // String
$numero = 42;              // Integer
$decimal = 3.14;           // Float
$esVerdadero = true;       // Boolean
$arreglo = [1, 2, 3];      // Array
?>
```

### Operadores Básicos
```php
<?php
// Aritméticos
$a + $b;  // Suma
$a - $b;  // Resta
$a * $b;  // Multiplicación
$a / $b;  // División
$a % $b;  // Módulo (resto)

// Comparación
$a == $b; // Igual
$a != $b; // Diferente
$a > $b;  // Mayor que
$a < $b;  // Menor que
?>
```

### Estructuras de Control

**Condicional if-else:**
```php
<?php
$edad = 18;

if ($edad >= 18) {
    echo "Eres mayor de edad";
} else {
    echo "Eres menor de edad";
}
?>
```

**Bucle for:**
```php
<?php
for ($i = 0; $i < 5; $i++) {
    echo "El número es: $i <br>";
}
?>
```

**Bucle while:**
```php
<?php
$contador = 0;
while ($contador < 5) {
    echo "Contador: $contador <br>";
    $contador++;
}
?>
```

### Funciones en PHP
```php
<?php
function saludar($nombre) {
    return "Hola, $nombre!";
}

echo saludar("Mundo");
?>
```

### Arrays en PHP
```php
<?php
// Array indexado
$frutas = ["Manzana", "Naranja", "Plátano"];
echo $frutas[0]; // "Manzana"

// Array asociativo
$persona = [
    "nombre" => "Juan",
    "edad" => 25,
    "ciudad" => "Santiago"
];
echo $persona["nombre"]; // "Juan"

// Recorrer array con foreach
foreach ($frutas as $fruta) {
    echo $fruta . "<br>";
}
?>
```

---

## Integración de PHP con HTML

```php
<!DOCTYPE html>
<html>
<head>
    <title>Mi Página PHP</title>
</head>
<body>
    <h1><?php echo "Bienvenido"; ?></h1>

    <?php
    $mensaje = "Este es un mensaje dinámico";
    ?>

    <p><?php echo $mensaje; ?></p>
</body>
</html>
```

---

## Conceptos Clave para el CMS

### 1. Formularios y Envío de Datos
```php
<?php
// Recibir datos del formulario (POST)
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

// Recibir datos de URL (GET)
$pagina = $_GET['pagina'];
?>
```

### 2. Include y Require de Archivos
```php
<?php
// Incluir archivos externos
include 'header.php';
include 'footer.php';

// Require detiene si hay error
require 'config.php';
?>
```

### 3. Trabajar con Archivos
```php
<?php
// Escribir en un archivo
$archivo = fopen("datos.txt", "w");
fwrite($archivo, "Hola mundo");
fclose($archivo);

// Leer un archivo
$contenido = file_get_contents("datos.txt");
echo $contenido;
?>
```

---

## 🎓 Demo del Docente — `creando-CMS`

> ⚠️ **Importante:** La carpeta [`creando-CMS/`](./creando-CMS/) es una **demostración del docente** que se utiliza como referencia visual durante las clases. **No debes copiarla ni entregarla como tu trabajo.**

Esta plantilla se construye en vivo clase a clase para mostrar:
- Cómo estructurar las vistas de un CMS (zona pública y zona privada)
- Cómo aplicar Bootstrap como framework CSS
- Buenas prácticas de UX/UI en formularios, tablas y navegación
- Cómo integrar PHP progresivamente en plantillas HTML

---

## 🛠️ Tu Misión — Crear tu Propio CMS

Tú debes construir **tu propio CMS desde cero**, con tu propio diseño, contenido y criterios. El demo es solo una guía de referencia.

### Páginas que debes crear:

| Archivo | Zona | Descripción |
|---|---|---|
| `index.html` | Pública | Listado de artículos con imagen, título, extracto, fecha y enlace |
| `detalle.html` | Pública | Despliegue individual del artículo completo |
| `login.html` | Pública | Formulario de acceso a la zona privada |
| `admin_listado.html` | Privada | Tabla con todos los artículos + botones editar/eliminar |
| `admin_insertar.html` | Privada | Formulario para crear un nuevo artículo |
| `admin_editar.html` | Privada | Formulario para modificar un artículo existente |
| `admin_list.php` | Privada | Copia de `admin_listado.html` con array PHP que puebla la tabla |

### Criterios que debes cumplir:

**HTML semántico**
- Usa etiquetas correctas: `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`, `<form>`
- Incluye atributos de accesibilidad (`alt`, `aria-label`, `lang`)

**Bootstrap 5**
- Usa el sistema de grilla (`container`, `row`, `col-*`) para el layout
- Aplica componentes: navbar, cards, tablas, formularios, botones, badges
- El diseño debe ser **responsivo** (mobile-first)

**CSS propio**
- Complementa Bootstrap con estilos propios en un archivo `assets/css/main.css`
- Define variables CSS (colores, tipografía, espaciados)
- No uses estilos `inline` — todo en la hoja de estilos

**UX/UI**
- La navegación debe ser clara e intuitiva
- Los formularios deben tener labels visibles y feedback al usuario
- Consistencia visual entre todas las páginas (mismo navbar, footer y paleta de colores)
- Jerarquía tipográfica legible (títulos, subtítulos, cuerpo)
- Contraste suficiente entre texto y fondo

**PHP — `admin_list.php`**
- Crea un array con mínimo **10 artículos** con esta estructura:
```php
<?php
$articulos = array(
    array('id' => 1, 'titulo' => 'Título del artículo 01'),
    array('id' => 2, 'titulo' => 'Título del artículo 02'),
    // ... hasta 10
);
?>
```
- Recorre el array con `foreach` y genera las filas de la tabla dinámicamente
- **No escribas los títulos hardcodeados en el HTML** — deben venir del array PHP

### Flujo de navegación esperado:

```
index.html  ──────►  detalle.html
     │
     └──►  login.html  ──►  admin_listado.html  ──►  admin_editar.html
                                    │
                                    └──►  admin_insertar.html
                                    └──►  admin_list.php (versión PHP)
```

---

## Recursos Adicionales

- Documentación oficial de PHP: https://www.php.net/docs.php
- Tutorial PHP para principiantes: https://www.w3schools.com/php/

---

## Actividad de la Semana

📋 **[Actividad Sumativa 01](./material-semana/)** - Revisa el material completo de la semana para más detalles sobre la evaluación.

---

*Última actualización: Semana 2 - Curso de Lenguajes de Programación*