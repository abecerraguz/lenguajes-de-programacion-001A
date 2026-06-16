# 🐘 Tipado en PHP — Guía para principiantes

> **¿Para quién es esto?** Para quienes están comenzando a programar y quieren entender qué son los **tipos de datos** y cómo PHP los maneja en funciones.

---

## 1. ¿Qué es un "tipo de dato"?

Cuando guardamos información en una variable, esa información tiene una **naturaleza**: puede ser un número, un texto, un valor verdadero/falso, etc. A eso le llamamos **tipo de dato**.

Piénsalo así:

| Información | Ejemplo | Tipo |
|-------------|---------|------|
| Un nombre | `"María"` | `string` (texto) |
| Una edad | `23` | `int` (número entero) |
| Un precio | `9990.50` | `float` (número decimal) |
| ¿Está activo? | `true` | `bool` (verdadero/falso) |

---

## 2. PHP sin tipado (modo "relajado")

PHP es un lenguaje que **por defecto no obliga** a declarar el tipo. Esto significa que una variable puede cambiar de tipo sin que el lenguaje proteste.

```php
<?php
$valor = "Hola";   // string
$valor = 42;       // ahora es int ¡y PHP no dice nada!
$valor = true;     // ahora es bool

echo $valor; // Muestra: 1
?>
```

⚠️ Esto puede causar **errores difíciles de detectar**, especialmente en funciones.

---

## 3. Funciones sin tipado — el problema

```php
<?php
function sumar($a, $b) {
    return $a + $b;
}

echo sumar(5, 3);        // 8   ✅ correcto
echo sumar("5", "3");    // 8   ✅ PHP convierte el texto a número
echo sumar("cinco", 3);  // 3   ⚠️ resultado inesperado, sin error
?>
```

Como ves, la función `sumar` acepta **cualquier cosa** y PHP intenta adivinar qué hacer. Esto puede producir resultados incorrectos silenciosamente.

---

## 4. Funciones CON tipado — la solución

A partir de **PHP 7**, podemos declarar el tipo de los **parámetros** y del **valor de retorno**. Esto hace que el código sea más claro y seguro.

### Sintaxis básica

```php
<?php
function nombre_funcion(tipo $parametro): tipo_retorno {
    // cuerpo de la función
}
?>
```

---

## 5. Ejemplo 1 — Función con `int`

```php
<?php
function sumar(int $a, int $b): int {
    return $a + $b;
}

echo sumar(10, 5);   // 15 ✅

// Si pasamos texto, PHP intentará convertirlo:
echo sumar("8", "2"); // 10 ✅ (convierte "8" → 8 automáticamente)

// Pero si el texto no es convertible:
echo sumar("diez", 5); // ❌ Error: el valor no se puede convertir a int
?>
```

> 💡 **¿Para qué sirve?** Nos asegura que la función trabaje solo con números enteros, evitando resultados inesperados.

---

## 6. Ejemplo 2 — Función con `string`

```php
<?php
function saludar(string $nombre): string {
    return "¡Hola, " . $nombre . "!";
}

echo saludar("Valentina");  // ¡Hola, Valentina! ✅
echo saludar(42);           // ¡Hola, 42! (PHP convierte 42 → "42")
echo saludar(true);         // ¡Hola, 1! (bool true → "1")
?>
```

---

## 7. Ejemplo 3 — Función con `float`

```php
<?php
function calcularDescuento(float $precio, float $porcentaje): float {
    return $precio - ($precio * $porcentaje / 100);
}

$precioFinal = calcularDescuento(15000.0, 20.0);
echo "Precio con descuento: $" . $precioFinal; // Precio con descuento: $12000 ✅
?>
```

---

## 8. Ejemplo 4 — Función con `bool`

```php
<?php
function esMayorDeEdad(int $edad): bool {
    return $edad >= 18;
}

$resultado = esMayorDeEdad(20);

if ($resultado) {
    echo "Puede ingresar ✅";
} else {
    echo "No puede ingresar ❌";
}
// Muestra: Puede ingresar ✅
?>
```

---

## 9. Modo estricto — el nivel más seguro

Si quieres que PHP sea **muy estricto** (que no haga conversiones automáticas), puedes activar el **modo estricto** al inicio del archivo:

```php
<?php
declare(strict_types=1); // ← Esta línea activa el modo estricto

function multiplicar(int $a, int $b): int {
    return $a * $b;
}

echo multiplicar(4, 3);    // 12 ✅
echo multiplicar("4", 3);  // ❌ Error: se esperaba int, se recibió string
?>
```

> 💡 **Con modo estricto activo**, PHP ya **no convierte automáticamente** los tipos. Si pasas el tipo incorrecto, el programa se detiene con un error claro.

---

## 10. Tipos con `?` — parámetros opcionales (nullable)

A veces un valor puede ser del tipo esperado **o puede no existir** (`null`). En ese caso usamos `?` antes del tipo:

```php
<?php
function mostrarNombreCompleto(string $nombre, ?string $apellido): string {
    if ($apellido === null) {
        return $nombre;
    }
    return $nombre . " " . $apellido;
}

echo mostrarNombreCompleto("Carlos", "González"); // Carlos González
echo mostrarNombreCompleto("Carlos", null);       // Carlos
?>
```

---

## 11. Resumen de tipos más usados

| Tipo | ¿Qué acepta? | Ejemplo |
|------|-------------|---------|
| `int` | Números enteros | `5`, `-12`, `0` |
| `float` | Números decimales | `3.14`, `9990.5` |
| `string` | Texto | `"Hola"`, `"PHP"` |
| `bool` | Verdadero o falso | `true`, `false` |
| `?tipo` | El tipo indicado o `null` | `?string`, `?int` |
| `void` | La función no retorna nada | (solo en retorno) |

---

## 12. Ejemplo integrador — Registro de alumno

```php
<?php
declare(strict_types=1);

function registrarAlumno(string $nombre, int $edad, float $promedio): string {
    if ($promedio >= 4.0) {
        $estado = "Aprobado ✅";
    } else {
        $estado = "Reprobado ❌";
    }

    return "Alumno: $nombre | Edad: $edad | Promedio: $promedio | Estado: $estado";
}

echo registrarAlumno("Ana Rojas", 20, 5.5);
// Alumno: Ana Rojas | Edad: 20 | Promedio: 5.5 | Estado: Aprobado ✅

echo registrarAlumno("Luis Pérez", 19, 3.2);
// Alumno: Luis Pérez | Edad: 19 | Promedio: 3.2 | Estado: Reprobado ❌
?>
```

---

## 13. Tipado con Clases

En PHP también puedes usar el **nombre de una clase** como tipo, tanto en parámetros como en el valor de retorno. Esto garantiza que solo se pase (o retorne) un objeto de esa clase específica.

### Sintaxis básica

```php
<?php
function nombre_funcion(NombreClase $objeto): NombreClase {
    // cuerpo
}
?>
```

---

### Ejemplo 1 — Clase como tipo de parámetro

```php
<?php
class Alumno {
    public string $nombre;
    public int $edad;

    public function __construct(string $nombre, int $edad) {
        $this->nombre = $nombre;
        $this->edad   = $edad;
    }
}

function mostrarAlumno(Alumno $alumno): string {
    return "Nombre: {$alumno->nombre} | Edad: {$alumno->edad}";
}

$a = new Alumno("Valentina", 20);
echo mostrarAlumno($a); // Nombre: Valentina | Edad: 20 ✅

// Si se pasa algo que NO es un Alumno:
echo mostrarAlumno("hola"); // ❌ Error: se esperaba Alumno, se recibió string
?>
```

> 💡 Al tipar con una clase, PHP verifica que el argumento sea una **instancia** de esa clase. Si no lo es, lanza un error inmediatamente.

---

### Ejemplo 2 — Clase como tipo de retorno

```php
<?php
class Producto {
    public string $nombre;
    public float  $precio;

    public function __construct(string $nombre, float $precio) {
        $this->nombre = $nombre;
        $this->precio = $precio;
    }
}

function crearProducto(string $nombre, float $precio): Producto {
    return new Producto($nombre, $precio);
}

$p = crearProducto("Teclado", 29990.0);
echo "{$p->nombre} cuesta \${$p->precio}"; // Teclado cuesta $29990 ✅
?>
```

---

### Ejemplo 3 — Clase nullable (`?Clase`)

Al igual que con los tipos primitivos, puedes permitir que el valor sea `null` usando `?`:

```php
<?php
class Usuario {
    public string $email;

    public function __construct(string $email) {
        $this->email = $email;
    }
}

function buscarUsuario(int $id): ?Usuario {
    if ($id === 1) {
        return new Usuario("ana@ejemplo.cl");
    }
    return null; // No encontrado
}

$u = buscarUsuario(1);
if ($u !== null) {
    echo "Encontrado: {$u->email}"; // Encontrado: ana@ejemplo.cl ✅
} else {
    echo "Usuario no encontrado ❌";
}
?>
```

---

### Ejemplo 4 — Métodos de clase con tipado (uso dentro de la propia clase)

```php
<?php
declare(strict_types=1);

class Carrito {
    private array $productos = [];

    public function agregar(Producto $producto): void {
        $this->productos[] = $producto;
    }

    public function total(): float {
        $suma = 0.0;
        foreach ($this->productos as $p) {
            $suma += $p->precio;
        }
        return $suma;
    }
}

$carrito = new Carrito();
$carrito->agregar(new Producto("Mouse", 9990.0));
$carrito->agregar(new Producto("Monitor", 189990.0));

echo "Total: $" . $carrito->total(); // Total: $199980 ✅
?>
```

---

### Resumen — tipos de clase

| Declaración | ¿Qué acepta? |
|-------------|-------------|
| `Alumno $a` | Solo instancias de la clase `Alumno` |
| `?Alumno $a` | Instancia de `Alumno` o `null` |
| `): Alumno` | La función debe retornar un objeto `Alumno` |
| `): ?Alumno` | La función puede retornar `Alumno` o `null` |
| `): void` | La función no retorna nada |

---

## ✅ Buenas prácticas al tipar funciones

1. **Siempre declara el tipo de los parámetros** cuando sepas qué tipo deben ser.
2. **Siempre declara el tipo de retorno** para que quede claro qué devuelve la función.
3. **Usa `declare(strict_types=1)`** en archivos donde la exactitud del tipo sea crítica.
4. **Usa `?tipo`** solo cuando el valor realmente pueda ser `null`, no por comodidad.
5. **Los nombres de funciones deben describir lo que hacen**: `calcularDescuento`, `esMayorDeEdad`, `registrarAlumno`.

---

> 📌 **Recuerda:** El tipado no hace que tu código funcione más rápido, pero sí lo hace más **legible**, más **seguro** y más **fácil de depurar** cuando algo sale mal.
