Semana 5: Desplegando el contenido de una base de datos
## ¿Qué es una Clase?

En PHP, una clase es como un plano o plantilla que define las propiedades (atributos) y comportamientos (métodos) de un objeto. Es decir, es una estructura que describe cómo serán los objetos que se creen a partir de ella.

### Ejemplo:
Imagina que quieres crear una clase para representar a una persona. Esta clase podría tener las siguientes propiedades:

	- nombre
	- edad
	- altura
	- peso

Y los siguientes métodos:

	- caminar()
	- hablar()
	- comer()



## Componentes principales de una clase
1. Propiedades:

- Son las variables que pertenecen a una clase.
- Definen las características o atributos del objeto.

2. Métodos:

- Son las funciones que pertenecen a una clase.
- Definen el comportamiento o las acciones que puede realizar un objeto.

3. Constructor:

- Es un método especial que se ejecuta automáticamente cuando se crea un objeto a partir de una clase.
- Se utiliza comúnmente para inicializar las propiedades del objeto.

4. Visibilidad:

- Determina el nivel de acceso a las propiedades y métodos.
- Los niveles de visibilidad son:
    - public: Accesible desde cualquier lugar.
    - protected: Accesible solo desde la clase y las clases derivadas.
    - private: Accesible solo desde la clase donde se define.

## Ejemplo básico de una clase en PHP


```php

    class Persona {
        // Propiedades
        public $nombre;
        public $edad;

        // Constructor
        public function __construct( $nombre, $edad) {
            $this->nombre = $nombre;
            $this->edad = $edad;
        }

        // Método
        public function saludar() {
            return "Hola, mi nombre es " . $this->nombre . " y tengo " . $this->edad . " años.";
        }
    }

    // Crear un objeto de la clase Persona
    $persona = new Persona("Juan", 30);

    // Acceder a un método
    echo $persona->saludar(); // Salida: Hola, mi nombre es Juan y tengo 30 años.

```

# Explicación del ejemplo

1. Definición de la clase:

    - class Persona { ... } define una clase llamada Persona.

2. Propiedades:

    - public $nombre; y public $edad; son las características del objeto.

3. Constructor:

    - __construct($nombre, $edad) inicializa las propiedades del objeto con los valores pasados al crear una nueva instancia.

4. Método:

    - saludar() es un método que devuelve un mensaje personalizado utilizando las propiedades de la clase.

5. Creación del objeto:
```php

    $persona = new Persona("Juan", 30); // crea una instancia de la clase Persona.

```

6. Acceso al método:
```php

    echo $persona->saludar(); // llama al método saludar() del objeto persona.

```

# Metodos para relaizar un include en PHP

| Método               | Uso Principal                                                                 | Ejecución              | Manejo de Errores                 | Diferencias Clave                                                                                                                                  |
|----------------------|------------------------------------------------------------------------------|------------------------|-----------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------|
| `include`           | Incluir un archivo y continuar si no se encuentra.                           | Se ejecuta siempre.    | Genera un **Warning** si falla.  | Ideal para incluir contenido no crítico. Si el archivo no se encuentra, el script continúa.                                                     |
| `require`           | Incluir un archivo y detener la ejecución si no se encuentra.                | Se ejecuta siempre.    | Genera un **Fatal Error** si falla. | Se usa para incluir contenido crítico, deteniendo la ejecución si el archivo no está disponible.                                                 |
| `include_once`      | Similar a `include`, pero asegura que el archivo solo se incluye una vez.     | Se ejecuta siempre.    | Genera un **Warning** si falla.  | Útil para evitar incluir el mismo archivo repetidamente, como en configuraciones globales.                                                       |
| `require_once`      | Similar a `require`, pero asegura que el archivo solo se incluye una vez.     | Se ejecuta siempre.    | Genera un **Fatal Error** si falla. | Combina las características de `require` y `include_once`. Ideal para incluir bibliotecas críticas solo una vez.                                 |

### Resumen de Usos
1. Usa **`include`** para archivos opcionales o no críticos.
2. Usa **`require`** para archivos esenciales que detendrán el script si no están disponibles.
3. Usa **`include_once`** o **`require_once`** para evitar conflictos al cargar un archivo varias veces en un mismo contexto.

### Ejemplos de uso para cada método de importar archivos en PHP:
```php

	// Archivo a importar: config.php
	// Contenido de config.php
	define('APP_NAME', 'Mi Aplicación');



```
1. include
Incluye el archivo y continúa ejecutándose incluso si el archivo no existe.
```php
	include 'config.php';

	echo APP_NAME; // Salida: Mi Aplicación

	// Si config.php no existe, genera un Warning pero el script continúa.
	include 'archivo_inexistente.php';
	echo 'El script sigue ejecutándose.';
```

2. require
Incluye el archivo, pero detiene la ejecución si el archivo no se encuentra.

```php

	require 'config.php';

	echo APP_NAME; // Salida: Mi Aplicación

	// Si config.php no existe, genera un Fatal Error y el script se detiene.
	require 'archivo_inexistente.php';
	echo 'Este mensaje no se mostrará.';

```

3. include_once
Incluye el archivo solo una vez, evitando duplicados si se vuelve a incluir.

```php

	include_once 'config.php';
	include_once 'config.php'; // No se vuelve a incluir.

	echo APP_NAME; // Salida: Mi Aplicación

```

4. require_once
Similar a require, pero asegura que el archivo solo se incluye una vez.

```php
	require_once 'config.php';
	require_once 'config.php'; // No se vuelve a incluir.

	echo APP_NAME; // Salida: Mi Aplicación

	// Si config.php no existe, genera un Fatal Error y el script se detiene.
	require_once 'archivo_inexistente.php';
```

### Nota
include y include_once permiten continuar con la ejecución incluso si no encuentran el archivo.
require y require_once detienen la ejecución si el archivo no se encuentra.

Esto te permite elegir la mejor opción según la importancia del archivo que deseas importar. 😊