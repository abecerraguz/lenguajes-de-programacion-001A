<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semana 1 – Aprendiendo a utilizar aspectos básicos de PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<section class="container my-5">

    <h1 class="mb-1">Semana 1 – Aspectos básicos de PHP</h1>
    <p class="text-muted mb-4">
        Exp1 · Lenguajes de Programación · Carrera Desarrollo y Diseño Web – DuocUC
    </p>
    <p>
        En esta actividad se aplican los conceptos fundamentales de PHP:
        <strong>variables, condicionales, funciones, matrices y bucles</strong>,
        resolviendo cuatro ejercicios prácticos.
    </p>
    <hr>

    <?php
    /*
    |--------------------------------------------------------------------------
    | EJERCICIO 1 – CONDICIONALES
    |--------------------------------------------------------------------------
    | Determinar si un número es positivo, negativo o cero usando if-else.
    |
    | Concepto clave:
    |   Los operadores condicionales permiten que el programa decida el camino
    |   a seguir según el cumplimiento de ciertas condiciones.
    |
    |   Sintaxis:
    |     if (condición) { ... } elseif (condición) { ... } else { ... }
    |
    | Nota: el valor se inicializa directamente en el código (sin validación
    |       de entrada de usuario, tal como indica la actividad formativa).
    */
    echo "<h2 class='mt-5'>Ejercicio 1 – Condicionales</h2><hr>";
    echo "<p>Determinar si un número es <strong>positivo</strong>, <strong>negativo</strong> o <strong>cero</strong>.</p>";

    // Variable con el número a evaluar (el programador asigna el valor)
    $numero = -7;

    echo "<p>Número evaluado: <strong>$numero</strong></p>";

    // Estructura if-elseif-else para evaluar el signo del número
    if ($numero > 0) {
        echo "<p class='text-success'>El número $numero es <strong>positivo</strong>.</p>";
    } elseif ($numero < 0) {
        echo "<p class='text-danger'>El número $numero es <strong>negativo</strong>.</p>";
    } else {
        echo "<p class='text-secondary'>El número es <strong>cero</strong>.</p>";
    }


    /*
    |--------------------------------------------------------------------------
    | EJERCICIO 2 – FUNCIONES
    |--------------------------------------------------------------------------
    | Definir una función "suma" que reciba dos parámetros numéricos (a, b)
    | y retorne la suma de ambos.
    |
    | Concepto clave:
    |   Las funciones son bloques de código reutilizables que realizan una
    |   tarea específica. Se declaran con la palabra "function", seguida del
    |   nombre y los parámetros entre paréntesis.
    |
    |   Para devolver un valor se utiliza "return".
    |   Para concatenar textos en PHP se usa el punto (.)
    */
    echo "<h2 class='mt-5'>Ejercicio 2 – Funciones</h2><hr>";
    echo "<p>Función <code>suma(\$a, \$b)</code> que devuelve la suma de dos números.</p>";

    // Declaración de la función suma
    function suma($a, $b) {
        return $a + $b; // retorna la suma de los dos parámetros
    }

    // Llamadas a la función con distintos valores
    $resultado1 = suma(5, 3);
    $resultado2 = suma(10, 25);
    $resultado3 = suma(-4, 8);

    echo "<p>suma(5, 3)   = <strong>" . $resultado1 . "</strong></p>";
    echo "<p>suma(10, 25) = <strong>" . $resultado2 . "</strong></p>";
    echo "<p>suma(-4, 8)  = <strong>" . $resultado3 . "</strong></p>";


    /*
    |--------------------------------------------------------------------------
    | EJERCICIO 3 – MATRICES (ARRAYS)
    |--------------------------------------------------------------------------
    | Completar la función "calcularPromedio" que recibe un arreglo de números
    | y retorna el promedio de esos números.
    |
    | Conceptos clave:
    |   - array(): crea un arreglo con múltiples valores en una sola variable.
    |   - count($array): devuelve la cantidad de elementos del arreglo.
    |   - array_sum($array): suma todos los valores del arreglo.
    |   - Los índices de un array en PHP empiezan en 0.
    |
    | Matriz multidimensional (bonus):
    |   Se puede almacenar información más compleja usando arrays dentro de
    |   arrays (ej.: nombre + calificación por estudiante).
    */
    echo "<h2 class='mt-5'>Ejercicio 3 – Matrices</h2><hr>";
    echo "<p>Función <code>calcularPromedio(\$numeros)</code> que calcula el promedio de un arreglo.</p>";

    // Definición de la función calcularPromedio
    function calcularPromedio($numeros) {
        $suma  = array_sum($numeros);   // suma todos los elementos del arreglo
        $total = count($numeros);       // cantidad de elementos
        return $suma / $total;          // promedio = suma / total
    }

    // Arreglo de notas (proporcionado en la actividad)
    $notas = array(80, 90, 75, 87, 92);

    // Llamada a la función y almacenamiento del resultado
    $promedio = calcularPromedio($notas);

    /*
     * implode(separador, array)
     * ─────────────────────────────────────────────────────────────────────────
     * Une todos los elementos de un array en un único string (texto),
     * separándolos con el carácter o texto que le indiquemos.
     *
     * Ejemplo:
     *   $notas = [80, 90, 75];
     *   implode(", ", $notas)  →  "80, 90, 75"
     *
     * Parámetros:
     *   1° separador → el texto que irá entre cada elemento (", " = coma + espacio)
     *   2° array     → el arreglo cuyos elementos queremos unir
     */
    echo "<p>Notas: <strong>" . implode(", ", $notas) . "</strong></p>";
    echo "<p>El promedio es: <strong>" . $promedio . "</strong></p>";

    // --- Bonus: matriz multidimensional con nombre + calificación ---
    echo "<br><p><strong>Bonus:</strong> array multidimensional – nombre y calificación de cada estudiante.</p>";

    /*
     * Matriz multidimensional: cada elemento es a su vez un array asociativo.
     * Dimensión 1 → lista de estudiantes
     * Dimensión 2 → claves 'nombre' y 'calificacion' de cada estudiante
     */
    $estudiantes = array(
        array("nombre" => "Carlos", "calificacion" => 85),
        array("nombre" => "Ana",    "calificacion" => 45),
        array("nombre" => "Luis",   "calificacion" => 70),
        array("nombre" => "María",  "calificacion" => 55),
        array("nombre" => "Sofía",  "calificacion" => 90)
    );

    // Variables acumuladoras
    $aprobados          = [];   // almacenará los nombres de quienes aprueben
    $sumaCalificaciones = 0;

    // Recorrer la matriz con foreach (itera sobre cada sub-array)
    foreach ($estudiantes as $estudiante) {
        $nombre        = $estudiante["nombre"];
        $calificacion  = $estudiante["calificacion"];
        $sumaCalificaciones += $calificacion;

        // Condicional: aprueba con calificación >= 60
        if ($calificacion >= 60) {
            $aprobados[] = $nombre; // agrega el nombre al arreglo de aprobados
            echo "<p class='text-success'>$nombre aprobó con $calificacion.</p>";
        } else {
            echo "<p class='text-danger'>$nombre reprobó con $calificacion.</p>";
        }
    }

    /*
     * array_column(array_multidimensional, clave)
     * ─────────────────────────────────────────────────────────────────────────
     * Extrae todos los valores de una columna específica de un array
     * multidimensional (funciona como una columna de tabla).
     *
     * Ejemplo:
     *   $estudiantes = [
     *     ["nombre" => "Carlos", "calificacion" => 85],
     *     ["nombre" => "Ana",    "calificacion" => 45],
     *   ];
     *   array_column($estudiantes, "calificacion")  →  [85, 45]
     *
     * Parámetros:
     *   1° array multidimensional → la lista de filas (array de arrays)
     *   2° clave                  → el nombre de la columna que queremos extraer
     */
    // Promedio general del grupo usando la función definida arriba
    $promedioGrupo = calcularPromedio(array_column($estudiantes, "calificacion"));

    echo "<p class='mt-2'>Promedio del grupo: <strong>$promedioGrupo</strong></p>";

    /*
     * implode() también se puede usar para mostrar una lista de nombres
     * en lugar de recorrer el array con foreach.
     * Aquí une los nombres del arreglo $aprobados separados por coma.
     */
    echo "<p>Estudiantes aprobados: <strong>" . implode(", ", $aprobados) . "</strong></p>";


    /*
    |--------------------------------------------------------------------------
    | EJERCICIO 4 – BUCLES
    |--------------------------------------------------------------------------
    | Imprimir los números pares del 0 al 20 usando tres tipos de bucles:
    |   1. for      → útil cuando se conoce cuántas iteraciones se harán.
    |   2. while    → se ejecuta mientras la condición sea verdadera.
    |   3. do-while → igual que while, pero se ejecuta AL MENOS una vez.
    |
    | Para detectar números pares se usa el operador módulo (%):
    |   $n % 2 === 0  →  el número es par (el residuo de dividir por 2 es 0)
    */
    echo "<h2 class='mt-5'>Ejercicio 4 – Bucles</h2><hr>";
    echo "<p>Números pares del 0 al 20 con tres tipos de bucles.</p>";

    // ── Bucle for ─────────────────────────────────────────────────────────────
    // Inicialización: $i = 0 | Condición: $i <= 20 | Incremento: $i++
    echo "<h5>Bucle <code>for</code>:</h5><p>";
    for ($i = 0; $i <= 20; $i++) {
        if ($i % 2 === 0) {     // verifica si $i es par
            echo $i . " ";
        }
    }
    echo "</p>";

    // ── Bucle while ───────────────────────────────────────────────────────────
    // Se ejecuta mientras $j sea menor o igual a 20
    echo "<h5>Bucle <code>while</code>:</h5><p>";
    $j = 0;
    while ($j <= 20) {
        if ($j % 2 === 0) {     // verifica si $j es par
            echo $j . " ";
        }
        $j++;                   // incremento manual para evitar bucle infinito
    }
    echo "</p>";

    // ── Bucle do-while ────────────────────────────────────────────────────────
    // Se ejecuta al menos una vez; luego verifica la condición al final
    echo "<h5>Bucle <code>do-while</code>:</h5><p>";
    $k = 0;
    do {
        if ($k % 2 === 0) {     // verifica si $k es par
            echo $k . " ";
        }
        $k++;                   // incremento manual para evitar bucle infinito
    } while ($k <= 20);
    echo "</p>";

    ?>

</section>
</body>
</html>



        </section>
        <!-- Incluir JS de BOOTSTRAP -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

