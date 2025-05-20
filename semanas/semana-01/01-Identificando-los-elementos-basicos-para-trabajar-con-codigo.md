# SEMANA 1

PHP (acrónimo recursivo de PHP: Hypertext Preprocessor) es un lenguaje de código abierto muy popular especialmente adecuado para el desarrollo web y que puede ser incrustado en HTML.


# Configuración mínima para trabajar con PHP 

## 1. Instalar un paquete todo-en-uno
La forma más sencilla de trabajar con PHP sin usar la terminal es instalar un paquete que incluya:
- **Servidor web (Apache o Nginx).**
- **PHP.**
- **Base de datos (opcional, como MySQL o MariaDB).**

### Opciones recomendadas:
- **[XAMPP](https://www.apachefriends.org/):**
  - Disponible para Windows, macOS y Linux.
  - Incluye Apache, PHP y MySQL con una interfaz gráfica.
- **[MAMP](https://www.mamp.info/):**
  - Ideal para macOS y Windows, fácil de configurar.
- **[Laragon](https://laragon.org/):**
  - Ligero y rápido, recomendado para Windows.

---

## 2. Configurar el servidor
1. **Instala el paquete elegido (ejemplo: XAMPP).**
2. Abre la interfaz gráfica del servidor.
3. Inicia el servidor Apache (y MySQL si lo necesitas).
4. Coloca tus archivos PHP en la carpeta pública del servidor:
   - En XAMPP: `htdocs` (normalmente en `C:\xampp\htdocs` en Windows o `/Applications/XAMPP/htdocs` en macOS).
   - En MAMP: `htdocs` también.
   - En Laragon: `www`.

---

## 3. Crear y ejecutar tu archivo PHP
1. Crea un archivo PHP en la carpeta pública del servidor. Por ejemplo:
   - `C:\xampp\htdocs\mi_proyecto\index.php`.

2. Escribe el código PHP:
	```php
		<?php
			echo "¡Hola, mundo!";
		?>
	```



## PARA ESCRIBIR PHP
```php

	<?php ?>

```

## USO DE COMENTARIOS
```php

	<?php
		//Comentarios en Line
		/*Comentarios en Bloque*/
	;?>

```

## SALIDA POR PANTALLA PHP
```php

	<?php
		print 'Hola';
		echo  'Hola', 'Hola de nuevo';
	?>

```

## VARIABLES TIPO CADENAS O STRING
```php

	<?php
		$nombre 	= 'Roberto';
		$apellido   = 'Rojas';
		echo "$nombre, $apellido"; // imprime "Roberto, Rojas"

		$4nombre    = 'aun no';   // inválido; comienza con un número
		$_4nombre   = 'aun no';  // válido; comienza con un carácter de subrayado
	?>

```

## VARIABLES TIPO NUMEROS INT
```php

	<?php
		$x = 5985;
		var_dump(is_int($x));//Imprime bool(true)
		echo '</br>';
		$x = 59.85;//Imprime bool(false)
		var_dump(is_int($x));
	?>

```

## VARIABLES TIPO NUMEROS FLOAT
```php

	<?php
		$x = 10.365;
		var_dump(is_float($x));
	?>

```

## ARRAYS
```php

	<?php
		// Array Indexado el orden es a través del indice.
		$cars = array("Volvo", "BMW", "Toyota");
		echo "Me gusta el " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";
	?>

	<?php
		// Array Asociativo, están ordenados en vase a una llave y el valor asociado a la llave.
		$color = array(

			'pasto' => 'Verde', 
			'cielo' => 'Celeste', 
			'mar' => 'Azul'
			
		);
		echo 'El color que indicaremos será el siguiente:'.$color['pasto'];
	?>


	<?php
		// Array Multidimencional Arreglos dentro de un Arreglo
		$frutas 
			array('Manzana','rojo','12'),
			array('Naranja','naranjo','10'),
			array('Pera','verde','18')
		)
		echo $frutas[0][0].' Su color es:'.$frutas[0][1].' y quedan disponibles '.$frutas[0][1];
	?>


```

## OPERADORES DE COMPARACIÓN
~~~html
==	Igual			$x == $y 
===	Identico		$x === $y 
!=	Distinto		$x != $y
<>	Distinto  		$x <> $y
!==	No es identico	$x !== $y
>	Mayor que		$x > $y
<	Menor que		$x < $y
>=	Mayor igual		$x >= $y
<=	Menor Igual 	$x <= $y
~~~

## OPERADORES DE INCREMENTO Y DECREMENTO
~~~html
++$x	Pre-incrementa
$x++	Post-incrementa
--$x	Pre-decrementa
$x--	Post-decrementa
~~~

## CONCATENAR VARIABLES
```php

	<?php 
		$numeroUno = 18;
		$numeroDos = ' de Septiembre'
		echo '<h1>'.$numeroUno.$numeroDos.'</h1>';
	?>

```

## ESTRUCTURA DE CONTROL

### Condicional IF
```php

	<?php
		$a = 100;
		$b = 0;
		if($a > $b){
		echo "a es mayor que b";
		}
	?>

```

### Condicional anidado con operadores de comparación y operador lógico
```php

	<?php
		$edad = 25;
		$ingresos = 3000;

		// Verificar si la persona es mayor de edad y tiene ingresos suficientes
		if ($edad >= 18 && $ingresos >= 2500) {
			echo "Eres mayor de edad y tienes ingresos suficientes.";
		} elseif ($edad < 18) {
			echo "Eres menor de edad.";
		} else {
			echo "No tienes ingresos suficientes.";
		}
	?>

	<?php
		$hora = 22; // Hora actual en formato de 24 horas
		$díaFestivo = true; // Si es día festivo

		// Verificar si es tarde o si es día festivo
		if ($hora >= 21 || $díaFestivo) {
			echo "Puedes quedarte despierto hasta tarde.";
		} else {
			echo "Es hora de dormir temprano.";
		}
	?>

```




### Funciones

Una función en PHP es un bloque de código que se puede reutilizar para realizar una tarea específica. Las funciones son útiles para evitar la repetición de código, organizar mejor tu programa y hacerlo más modular.

### Definición de una función
En PHP, una función se define con la palabra clave function, seguida del nombre de la función, paréntesis (que pueden contener parámetros) y un bloque de código encerrado en llaves {}.

```php
	function nombreFuncion($parametro1, $parametro2) {
		// Código que realiza la función
		return $resultado; // Opcional
	}
```

### Ejemplo básico: Función para sumar dos números

```php

	<?php
		// Definir la función
		function sumar($numero1, $numero2) {
			$resultado = $numero1 + $numero2;
			return $resultado; // Devuelve el resultado de la suma
		}

		// Llamar a la función
		$suma = sumar(5, 10);
		echo "La suma es: " . $suma; // Salida: La suma es: 15
	?>

```

### Ejemplo avanzado: Función con valor por defecto

```php
	<?php
	function saludar($nombre = "Invitado") {
		return "Hola, " . $nombre . "!";
	}

	// Llamar a la función con un argumento
	echo saludar("Carlos"); // Salida: Hola, Carlos!

	// Llamar a la función sin argumentos
	echo saludar(); // Salida: Hola, Invitado!
?>


```

### Ejemplo: Función sin parámetros

```php
	<?php
		function mostrarFechaActual() {
			echo "La fecha actual es: " . date("Y-m-d");
		}

		// Llamar a la función
		mostrarFechaActual(); // Salida: La fecha actual es: 2024-12-24
	?>
```



### Bucle o Loop While
```php
	<?php
		$a = 0;
		while($a <= 10){
		$a++;
		echo '<h1>'.$a.'</h1>';
		}
	?>
```

### Bucle o Loop Do While
```php
	<?php
		// Se ejecuta primero.
		$a = 1;
		do{
			echo 'El número es:'.$a.'<br>';
			$a++
		// Luego evalúa.
		}while($a <= 10);
	?>
```

### Bucle o Loop For
```php
	<?php  
		for ($x = 0; $x <= 10; $x++) {
		    echo 'El número es:'.$x.'<br>';
		}
	?> 
```

### Bucle o Loop Foreach
```php
	<?php 
		//Recorre un array
		$frutas = array('Manzana','Pera','Naranja','Frutilla'); 
		foreach ($frutas as $valor) {
		echo "La fruta es:'.$frutas.'<br>';
		}
	?> 
```

# Experiencia de Aprendizaje 1: Comprendiendo los elementos básicos de programación.

## Semana 1
### Ejercicio formativo 1 : Clase sincrónica sistema de calificaciones 

Crea un programa en PHP que evalúe las calificaciones de un grupo de estudiantes y determine:

-	Si cada estudiante aprobó o reprobó.
-	El promedio general del grupo.
-	Los nombres de los estudiantes que aprobaron.

### Requisitos
1.	Define un array con los nombres de los estudiantes y sus respectivas calificaciones.
2.	Usa una función para determinar si un estudiante aprueba (nota mayor o igual a 60).
3.	Usa estructuras de control if para verificar las condiciones.
4.	Calcula el promedio del grupo.
5.	Muestra los resultados.

### Solución ejercicio
[Actividad Formativa 01](https://github.com/abecerraguz/lenguajes-de-programacion-001A/tree/main/actividades-formativas/semana-01)

## Semana 2
### Actividad Sumativa 1: Preparando las plantillas para un CMS

[Actividad Sumativa 01](https://github.com/abecerraguz/lenguajes-de-programacion-001A/tree/main/actividades-sumativas/semana-02/proyecto-cms)

### Cierre de Experiencia 1
[Video Cierre, Experiencia de Aprendizaje 1: Comprendiendo los elementos básicos de programación.](https://drive.google.com/file/d/1XrqAl59D_n8J55hMyOGG-1fXv_E245LG/view?usp=sharing)