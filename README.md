# Hitos de la asignatura

## Lenguajes de programación

Propósito: Armar un CMS (Content Management System) administrable utilizando bases de datos y considerando requisitos del proyecto y `criterios de diseño y
funcionalidad.`

Evaluación final transversal: La evaluación final transversal es un encargo sin presentación que consiste en el desarrollo de un CMS (Content Management System) administrable en el servidor


## Experiencia 1
Comprendiendo los elementos básicos de programación.

| Semana | Actividad | Tipo | Ponderación | Fecha de inicio | Fecha de termino |
|--------|-----------|----------|----------|----------|----------|
| 1      | Formativa 1:Identificando los elementos básicos para trabajar con código. | Individual | 0% | Martes 24 de Diciembre | Lunes 30 de Diciembre |
| 2      | Sumativa 1:Utilizando framework para crear un CMS. | Individual | 👉 20% | Martes 31 de Diciembre | Lunes 06 de enero |

## Experiencia 2
Aplicando PHP para realizar interacciones con la base de datos

| Semana | Actividad | Tipo | Ponderación | Fecha de inicio | Fecha de termino |
|--------|-----------|----------|----------|----------|----------|
| 3     | Formativa 2:Creando una base de datos | Individual | 0% | Martes 07 de Enero | Lunes 13 de Enero |
| 4     | Formativa 3:Realizando consultas SQL para trabajar con bases de datos | Individual | 0% | Martes 14 de enero | Lunes 20 de enero |
| 5     | Sumativa 2:Desplegando el contenido de una base de datos con PHP. | Individual | 👉 40% | Martes 21 de enero | Lunes 27 de enero |


## Experiencia 3
Programando un CMS administrable vía Internet

| Semana | Actividad | Tipo | Ponderación | Fecha de inicio | Fecha de termino |
|--------|-----------|----------|----------|----------|----------|
| 6   | Formativa 4:Aplicando las acciones básicas para gestión de datos. | Individual | 0% | Martes 28 de enero | Lunes 03 de febrero |
| 7   | Formativa 5:Programando acciones en PHP para traspasar información entre páginas. | Individual | 0% | Martes 04 de febrero | Lunes 10 de febrero |
| 8   | Sumativa 3:Utilizando PHP para interactuar con la base de datos y restringir accesos. | Individual | 👉 40% | Martes 11 de Febrero | Lunes 17 de febrero |


## Evaluación Final Transversal
| Semana | Actividad | Tipo | Ponderación | Fecha de inicio | Fecha de termino |
|--------|-----------|----------|----------|----------|----------|
| 9    | Sumativa | Individual | 👉 40% | Juyeves 13 de febrero | Domingo 23 de febrero |

# SEMANA 1
Creación de Blog en [https://wordpress.com/](https://wordpress.com/)

<section>

# FUNDAMENTOS DE PHP PARA DESARROLLO DE THEMES EN WORDPRESS

![Landing More Themes](screenshot_landing.png)

PHP (acrónimo recursivo de PHP: Hypertext Preprocessor) es un lenguaje de código abierto muy popular especialmente adecuado para el desarrollo web y que puede ser incrustado en HTML.


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
		$color = array('pasto' => 'Verde', 'cielo' => 'Celeste', 'mar' => 'Azul');
		echo 'El color que indicaremos será el siguiente:'.$color['pasto'];
	?>


	<?php
		// Array Multidimencional Arreglos dentro de un Arreglo
		$frutas array(
		
			array('Manzana','rojo','12'),
			array('Naranja','naranjo','10'),
			array('Pera','verde','18')

			echo $frutas[0][0].' Su color es:'.$frutas[0][1].' y quedan disponibles '.$frutas[0][1];
		)
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

## ESTRUCTURA DE CONTROL MÁS UTILIZADAS EN WORDPRESS

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

</section>



