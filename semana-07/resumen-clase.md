# Semana 7 – Programando acciones para traspasar información entre páginas

**Carrera:** Desarrollo y Diseño Web — Lenguaje de Programación
![Infografía](meterial-clase/infografia.png)
**Experiencia 3 – Semana 7**

---

## 1. Idea central de la semana

Hasta la Semana 6, el CMS tenía páginas que funcionaban de forma aislada (listado, inserción, edición), pero **no "conversaban" entre sí**. Esta semana se cierra ese vacío: se aprende a **traspasar información entre páginas** (vía la URL o vía formularios) para que el listado sepa qué artículo editar, eliminar o mostrar en detalle.

Con esto se completa el ciclo **CRUD** (Create, Read, Update, Delete) y se construye la página pública de **detalle** del CMS.

[Descargar presentación](meterial-clase/presentacion.pdf)
---

## 2. Resultados de aprendizaje e indicadores de logro

**RA1.** Usa el lenguaje de programación para proponer soluciones creativas de manejo de contenido dinámico.
**RA2.** Programa acciones de interacción definiendo base de datos vía SQL, considerando framework CSS, usabilidad y accesibilidad.

Indicadores de logro clave de esta semana:
- **IL7.** Programa acciones CRUD en la base de datos utilizando PHP.
- **IL8.** Aplica lenguaje de programación para crear una funcionalidad que permita el intercambio de información entre páginas web.

---

## 3. Conceptos clave

| Concepto | Idea principal |
|---|---|
| **GET** | Envía datos visibles en la URL (query string). Solo texto, tamaño limitado, no apto para datos sensibles. |
| **POST** | Envía datos en el cuerpo de la petición, no quedan visibles en la URL. Permite cualquier tipo de dato (texto, archivos, imágenes). |
| **Variables superglobales** | `$_GET[]` y `$_POST[]`: arrays de PHP que permiten recuperar lo enviado desde un formulario o una URL. |
| **CRUD** | Create, Read, Update, Delete — las 4 operaciones básicas sobre datos. |
| **Estructura del enlace** | `[página de destino][separador ?][variable]=[valor]`, ej: `admin_editar.php?id=3` |

---

## 4. GET vs POST — diferencias prácticas

**POST**
- Datos NO visibles en la URL, no quedan en el historial del navegador.
- Sin límite específico de tamaño.
- Permite enviar texto, imágenes, archivos.

**GET**
- Datos visibles en la URL (query string), quedan en el historial.
- Tamaño limitado por la longitud máxima de la URL.
- Solo texto.
- No recomendado para datos confidenciales.

**Regla práctica:** POST para datos sensibles o envíos grandes; GET para compartir URLs con parámetros visibles (ej: enlaces a "editar" o "ver detalle").

---

## 5. Recibiendo datos con PHP

```php
<?php
$nombre = $_POST['nombre']; // si el formulario usó method="POST"
echo $nombre;
?>
```

```php
<?php
$nombre = $_GET['nombre']; // si el dato viene por la URLlll
echo $nombre;
?>
```

⚠️ El nombre del dato a recuperar siempre va **entre comillas simples** dentro de los corchetes.

---

## 6. Enlazando el administrador (admin_listado.php)

### a) Link para agregar un nuevo artículo
```html
<a href="admin_insertar.php">Agregar nuevo artículo</a>
```

### b) Link para editar un artículo específico
Estructura del enlace: `admin_editar.php?id=[valor]`

```html
<td>
  <a href="admin_editar.php?id=<?php echo $articulo["a_id"]; ?>">Editar</a>
</td>
```

### c) Link para borrar un artículo (con confirmación)
```html
<td>
  <a href="admin_editar.php?id=<?php echo $articulo["a_id"]; ?>">Editar</a> -
  <a href="admin_listado.php?id=<?php echo $articulo["a_id"]; ?>"
     onclick="return confirm('Seguro/a que desea borrar este registro?')">Borrar</a>
</td>
```
- `confirm()` muestra un cuadro de diálogo de JavaScript.
- Si el usuario cancela → la función retorna `false` y el enlace no se ejecuta.
- Si acepta → retorna `true` y se ejecuta el borrado.

Lógica de borrado (al inicio del archivo, tras la conexión a la BD):
```php
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

if ($_GET['idb'] != "") {
    $idB = $_GET['idb'];
    $db->query('DELETE FROM cms_articulos WHERE a_id = ' . $idB);
}
```

---

## 7. admin_editar.php — hacerlo dinámico

**Problema:** la página siempre cargaba el mismo artículo porque el ID estaba "hardcodeado":
```php
$idArticulo = 1; // valor fijo ❌
```

**Solución:** reemplazar por la variable enviada desde la URL (método GET):
```php
$idArticulo = $_GET['id']; // valor dinámico ✅
```

Con esto, la consulta SQL que ya existía trae los datos del artículo correcto:
```php
$articulo = $db->query('SELECT * FROM cms_articulos WHERE a_id = ' . $idArticulo)->fetchAll();
```

El campo oculto del formulario `txtID` recibe ese mismo `a_id` para luego usarse en el `UPDATE` al guardar los cambios (vía `$_POST['txtID']`).

También se agrega un enlace para volver sin guardar cambios:
```html
<a href="admin_listado.php">Volver a la página principal</a>
```

---

## 8. admin_insertar.php

Se agrega el mismo tipo de enlace de "volver" (sin necesidad de pasar variables, ya que es para crear un artículo nuevo):
```html
<a href="admin_listado.php">Volver a la página principal</a>
```

---

## 9. Crear detalle.php (página pública)

### Paso 1 — Conexión y consulta (antes del HTML)
```php
<?php
include_once('clases/db.php');
include_once('clases/config.php');

$id = $_GET['id'];
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$articulo = $db->query(
  'SELECT a_id, a_titulo, a_texto, a_autor, a_resumen, a_fecha, u_nombre
   FROM cms_articulos
   INNER JOIN cms_usuarios ON cms_usuarios.u_id = cms_articulos.a_autor
   WHERE cms_articulos.a_id = ' . $id
)->fetchAll();
?>
```

### Paso 2 — Despliegue del detalle (en el cuerpo HTML)
```html
<div class="col-12">
  <h1><?php echo $articulo[0]["a_titulo"]; ?></h1>
  <p><em><?php echo $articulo[0]["a_resumen"]; ?></em></p>
  <p>Por: <?php echo $articulo[0]["u_nombre"]; ?></p>
  <p>Fecha de Publicación: <?php echo $articulo[0]["a_fecha"]; ?></p>
  <hr>
  <p><?php echo $articulo[0]["a_texto"]; ?></p>
</div>
```

### Paso 3 — Enlace "Ver más" desde index.php (listado público)
```html
<p><a href="detalle.php?id=<?php echo $articulo["a_id"]; ?>">Ver mas</a></p>
```

Con esto, cada tarjeta de artículo en `index.php` enlaza a su propia página de detalle, completando la parte pública del CMS.

---

## 10. Resumen del flujo completo de la semana

1. **admin_listado.php** → enlaza a `admin_insertar.php`, `admin_editar.php?id=X` y borra con `?idb=X`.
2. **admin_editar.php** → recibe `id` por GET, consulta el artículo correspondiente y permite editarlo (POST al guardar).
3. **admin_insertar.php** → agrega un nuevo artículo, con opción de volver sin guardar.
4. **Borrado** → se ejecuta vía `$_GET['idb']` con confirmación JavaScript antes de redirigir.
5. **detalle.php** → recibe `id` por GET desde `index.php` y muestra toda la información del artículo (público).

---

## 11. Preguntas de reflexión (para discutir en clase)

- ¿Cómo modificarías el código para que en lugar de GET se usara POST?
- ¿Qué riesgos de seguridad tiene el CMS construido hasta ahora? *(pista: datos visibles en URL, inyección SQL por concatenación directa de variables, falta de validación/escape de inputs)*

---

## 12. Antes de empezar (checklist técnico)

- [ ] En la carpeta `htdocs/CMS` de XAMPP, crear el archivo **detalle.php**.
- [ ] Verificar que `admin_listado.php`, `admin_editar.php` y `admin_insertar.php` ya existan desde la Semana 6.
- [ ] Tener la conexión a base de datos (`clases/db.php` y `clases/config.php`) funcionando.

---

## 13. Lectura complementaria

📖 Rollet, O. (2015). *Aprender a desarrollar un sitio web con PHP y MySQL: ejercicios prácticos y corregidos.* Capítulo 5: "Transmitir datos de una página a otra" (págs. 173–231). Disponible en biblioteca Duoc UC.

---

*Resumen elaborado a partir del material de la Semana 7 — Experiencia 3, Duoc UC.*
