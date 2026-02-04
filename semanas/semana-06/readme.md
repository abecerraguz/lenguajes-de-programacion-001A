# Flujo de trabajo CRUD (carpeta `admin/`) + GET vs POST

Este documento explica **cómo funciona tu CRUD actual**, entrega una estrategia clara para explicar a mis estudiantes **cuándo y por qué se usa `GET` o `POST`**, y cómo se relaciona con:

- `admin_list.php`
- `admin_insertar.php`
- `post_insertar.php`
- `admin_eliminar.php`
- `delete.php`

> Idea central: **GET = “pedir/ver/ir a una pantalla”** y **POST = “enviar datos para guardar/cambiar algo”**.

---

## 1) Mapa mental rápido (lo que debes repetir siempre)

### GET (navegación / lectura)
- Se usa para **abrir páginas** o **solicitar información**.
- Los datos viajan en la URL: `...?id=10`
- Ejemplos típicos:
  - Abrir listado: `admin_list.php`
  - Abrir formulario: `admin_insertar.php`
  - Abrir edición con id: `admin_editar.php?id=15`
  - Confirmar eliminación (mostrar modal/confirmación): normalmente disparado desde UI.

### POST (envío / escritura)
- Se usa para **enviar datos** que **crean o modifican** información.
- Los datos viajan en el cuerpo del request (no en la URL).
- Ejemplos típicos:
  - Insertar: formulario `admin_insertar.php` → `post_insertar.php` (POST)
  - Eliminar confirmado: `delete.php` (POST o GET, según tu implementación)

---

## 2) ¿Qué es `$_SERVER["REQUEST_METHOD"]`?

`$_SERVER["REQUEST_METHOD"]` es una variable que PHP expone para saber **cómo llegó la petición**:

- Si el usuario **abre una URL** desde el navegador o hace clic en un link → normalmente es **GET**
- Si el usuario **envía un formulario** (`<form method="POST">`) → es **POST**

Ejemplos:

```php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Se está pidiendo/ver una página o recurso
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Se están enviando datos (guardar, actualizar, eliminar)
}
```

### ¿Para qué sirve revisarlo?
Para **proteger el flujo** y evitar que alguien ejecute operaciones “por accidente” o “a mano” escribiendo la URL.

Ejemplo didáctico:
- `post_insertar.php` **solo debe aceptar POST**
- Si alguien intenta abrirlo directo en el navegador (GET), tu código lo **bloquea** y redirige con un mensaje.

---

## 3) Flujo real de tu CRUD (paso a paso)

## A) Listado (Read)
**Archivo:** `admin_list.php`

### Qué hace
1. Incluye dependencias (`config`, `db`, `header`, `admin_eliminar.php`)
2. Conecta a la BD
3. Ejecuta un `SELECT` (con `INNER JOIN` para traer autor)
4. Recorre resultados y muestra la tabla
5. Muestra acciones:
   - Editar (link con `?id=...`)
   - Eliminar (abre modal)

### Cómo explicarlo con GET/POST
- **Entrar al listado** es un **GET**:
  - “Estoy pidiendo ver información”
- Los links de edición usan **GET** porque pasan un `id` por URL:
  - `admin_editar.php?id=123`

---

## B) Ir al formulario “Nueva publicación” (Create - pantalla)
**Desde:** botón “Nueva publicación” en `admin_list.php`  
**Hacia:** `admin_insertar.php`

### Qué hace
- Solo muestra un formulario HTML.
- Importante: **no inserta nada** todavía.

### Método
- Abrir `admin_insertar.php` es **GET**
  - “Solo quiero ver el formulario”

---

## C) Enviar formulario para insertar (Create - acción)
**Formulario:** `admin_insertar.php`  
**Action:** `post_insertar.php`  
**Method:** `POST`

### Qué ocurre
1. Usuario completa `title`, `excerpt`, `content`
2. Presiona “Guardar”
3. El navegador envía los datos por **POST** a `post_insertar.php`

### Por qué es POST (explicación corta para alumnos)
- Porque aquí **sí hay una acción que cambia la base de datos** (INSERT).
- No conviene que esos datos viajen en la URL.

---

## D) Captura y validación del método (Create - backend)
**Archivo:** `post_insertar.php`

Tu lógica central es:

1. Capturas datos con `$_POST[...]`
2. Verificas el método:
   ```php
   if ($_SERVER['REQUEST_METHOD'] == "POST") {
       // Insertar en BD
   } else {
       // Bloquear y redirigir
   }
   ```
3. Insertas en la BD
4. Rediriges al listado con un mensaje:
   - `admin_list.php?info=...`

### Qué debes reforzar acá
- `$_POST` solo tiene datos si el request fue **POST**
- `$_GET` solo tiene datos si vienen por **URL**
- La verificación del método funciona como **“filtro de seguridad y coherencia del flujo”**

---

## E) Eliminación (Delete) — visión general
Tú lo tienes distribuido así:

- `admin_eliminar.php` (genera el modal/confirmación, por ejemplo)
- `delete.php` (ejecuta el borrado)

### Forma didáctica de explicarlo (sin asumir implementación exacta)
1. En `admin_list.php` el botón “Eliminar” **no elimina**, solo abre el modal.
2. El modal confirma y luego llama a `delete.php` con el `id` del post.
3. `delete.php` ejecuta el `DELETE` en BD y redirige al listado.

**Idea clave para el alumno:**
- “Eliminar” es **una operación de escritura**, por lo tanto conceptualmente es **POST** (porque cambia datos).
- El `id` que identifica qué borrar puede venir:
  - por URL (`GET`) o
  - por formulario (`POST`)

Pero el concepto que importa en la explicación es:
> **Si afecta la BD, no es solo navegación.**

---

## 4) Estrategia pedagógica para explicar GET vs POST (simple y efectiva)

### Estrategia 1: “Ver vs Hacer”
- **GET = VER**
  - ver lista
  - ver formulario
  - ver pantalla de edición
- **POST = HACER**
  - guardar publicación
  - actualizar publicación
  - eliminar publicación

Frase para repetir:
> “GET trae pantallas/datos. POST manda datos para cambiar algo.”

---

### Estrategia 2: “¿Dónde viajan los datos?”
- **GET:** viajan en la URL  
  `admin_editar.php?id=10`
- **POST:** viajan ocultos en el cuerpo del request  
  (no los ves en la barra de direcciones)

---

### Estrategia 3: “Qué superglobal uso”
- Si vienen por URL → `$_GET`
- Si vienen por formulario POST → `$_POST`
- **Y siempre puedo verificar** con `$_SERVER["REQUEST_METHOD"]`

Mini-checklist para alumno:
- “¿Estoy haciendo clic en un link?” → probablemente GET  
- “¿Estoy enviando un formulario?” → probablemente POST

---

## 5) Diagrama del flujo (para explicar en 1 minuto)

```
[admin_list.php]  (GET)
   |  click "Nueva publicación"
   v
[admin_insertar.php]  (GET)
   |  submit <form method="POST" action="post_insertar.php">
   v
[post_insertar.php]  (POST)
   |  INSERT en BD
   v
[admin_list.php?info=...]  (GET)   <-- vuelve al listado con mensaje
```

---

## 6) Cómo explicar la validación `REQUEST_METHOD` con un ejemplo real

### Caso real: alguien intenta abrir `post_insertar.php` directo
- Si escriben en el navegador:  
  `http://localhost/admin/post_insertar.php`
- Eso llega como **GET**, no hay datos en `$_POST`

Tu control:
```php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // ok, viene desde el form
} else {
  header("Location:admin_list.php?info=El metodo de consulta no es POST!");
  exit();
}
```

**Mensaje docente:**
- “Esto evita que ejecuten inserciones por error o sin formulario.”

---

## 7) Recomendación de cómo contarlo en clase (guion breve)

1. “Partimos en `admin_list.php`: es el panel administrador, muestra publicaciones (SELECT).”
2. “Clic en ‘Nueva publicación’ abre `admin_insertar.php` (GET). Solo muestra un formulario.”
3. “Al enviar el formulario, el navegador manda un POST a `post_insertar.php` (porque vamos a guardar).”
4. “`post_insertar.php` verifica `REQUEST_METHOD` para asegurar que efectivamente llega por POST.”
5. “Inserta en la BD y redirige al listado con un mensaje.”

---

## 8) Glosario mínimo (para que no se pierdan)

- **Request (petición):** lo que el navegador le pide al servidor.
- **Response (respuesta):** lo que el servidor devuelve (HTML, redirect, etc.).
- **Redirect (header Location):** enviar al navegador a otra URL.
- **GET:** petición para ver/consultar.
- **POST:** petición para enviar/guardar/cambiar.

---

## 9) Checklist final (para tus alumnos)

- [ ] ¿Estoy abriendo una página? → probablemente **GET**
- [ ] ¿Estoy enviando datos para guardar? → **POST**
- [ ] ¿Necesito leer el `id` desde la URL? → `$_GET['id']`
- [ ] ¿Necesito leer campos del formulario? → `$_POST['title']`, `$_POST['content']`
- [ ] ¿Quiero asegurar que no entren por el método incorrecto? → `$_SERVER["REQUEST_METHOD"]`

---

### Fin
Si quieres, puedo generar un **diagrama más visual** (tipo “cajas y flechas”) o una **versión 1 página** para pegar en el AVA.
