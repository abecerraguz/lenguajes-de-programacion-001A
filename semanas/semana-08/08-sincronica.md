# Uso seguro de contraseñas en PHP: `password_hash()` y `password_verify()`

## ¿Por qué hashear contraseñas?

- Nunca debes guardar contraseñas en texto plano en tu base de datos.
- Un **hash** es una versión cifrada y unidireccional de la contraseña que **no se puede revertir** a su valor original.
- Usar funciones seguras como `password_hash()` y `password_verify()` es la mejor práctica en PHP para proteger contraseñas.

---

## `password_hash()`

```php
$password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
```

- **¿Qué hace?**
  - Toma una contraseña en texto plano (`$plain_password`, por ejemplo "miclave123").
  - Genera un **hash seguro** usando el algoritmo recomendado por PHP (`PASSWORD_DEFAULT`).
  - Añade automáticamente un **salt** (valor aleatorio) para que dos contraseñas iguales generen hashes diferentes.
- **¿Qué devuelve?**
  - Un string largo que representa el hash. Ejemplo:
    ```
    $2y$10$JwqQkZuvz52Qmlp25BeyM.bsk9es5CQOr5HcVfT0qaf5Qd8ZzP6Xm
    ```
- **¿Por qué es seguro?**
  - El salt y la dificultad del algoritmo lo hacen resistente a ataques por fuerza bruta y rainbow tables.

---

## `password_verify()`

```php
if (password_verify($plain_password, $password_hash)) {
    // Contraseña correcta
}
```

- **¿Qué hace?**
  - Compara la contraseña en texto plano (`$plain_password`) con el hash almacenado (`$password_hash`).
  - Devuelve `true` si coinciden, `false` si no.
  - El salt es gestionado automáticamente por la función a partir del hash guardado.

---

## **Ejemplo de uso completo**

```php
// Al registrar o cambiar la contraseña de un usuario
$hash = password_hash('miclave123', PASSWORD_DEFAULT); // Guardar $hash en la base de datos

// Al hacer login:
if (password_verify('miclave123', $hash)) {
    echo "¡Contraseña correcta!";
} else {
    echo "Contraseña incorrecta";
}
```

---

## **Resumen visual**

- `password_hash()`  →  **Texto plano** → **Hash seguro** (se guarda en la BD)
- `password_verify()`  →  **Texto plano + Hash seguro** → **true/false** (para login)

---

## Recomendaciones de seguridad adicionales

- Nunca compares contraseñas directamente, siempre utiliza `password_verify()`.
- Siempre utiliza `PASSWORD_DEFAULT` para asegurarte que PHP elija el mejor algoritmo disponible.
- Cambia el tipo de campo de tu base de datos a `VARCHAR(255)` para almacenar los hashes.

---

**¡Utiliza siempre estas funciones para proteger a tus usuarios!**

# Para hacer la modificación en la tabla `cms_usuarios`
Para identificar de forma correcta el nombre de la columna que gaurda las contraseñas las vamos a cambiar de :
- u_password a u_password_hash.
- Cambiar de VARCHAR(20) a VARCHAR(255).

# Dejo funcion para agregar en la clase DB
Esta funcion cambia las contraseñas planas a contraseñas cifradas


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

Como usarla Ejemplo :

```php

    include_once('../class/config.php');
    include_once('../class/db.php'); 

    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    $db->updatePasswordHash(1, 'abecerra123');


```