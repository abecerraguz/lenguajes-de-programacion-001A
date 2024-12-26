<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formativa 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
        <section class="container">

        <?php

            echo "<h1>Ejercicio formativo 1: Clase sincrónica </h1>";

            echo "<p>Crea un programa en PHP que evalúe las calificaciones de un grupo de estudiantes y determine:</p>";
            echo "<ul>";
                echo "<li>Si cada estudiante aprobó o reprobó.</li>";
                echo "<li>El promedio general del grupo.</li>";
                echo  "<li>Los nombres de los estudiantes que aprobaron.</li>";
            echo "</ul>";

            // 1. Define un array con los nombres de los estudiantes y sus respectivas calificaciones.
            echo "<h4 class='mt-5'>1. Define un array con los nombres de los estudiantes y sus respectivas calificaciones.</h4>";
            echo "<hr>";
            $estudiantes = [
                ["nombre" => "Carlos", "calificacion" => 85],
                ["nombre" => "Ana", "calificacion" => 45],
                ["nombre" => "Luis", "calificacion" => 70],
                ["nombre" => "María", "calificacion" => 55],
                ["nombre" => "Sofía", "calificacion" => 90]
            ];

            // echo  "El nombre del estudiante es ".$estudiantes[0]['nombre']." su calificación es ".$estudiantes[0]['calificacion']."<br>";
            // echo  "El nombre del estudiante es ".$estudiantes[1]['nombre']." su calificación es ".$estudiantes[1]['calificacion']."<br>";
            // echo  "El nombre del estudiante es ".$estudiantes[2]['nombre']." su calificación es ".$estudiantes[2]['calificacion']."<br>";
            // echo  "El nombre del estudiante es ".$estudiantes[3]['nombre']." su calificación es ".$estudiantes[3]['calificacion']."<br>";
            // echo  "El nombre del estudiante es ".$estudiantes[4]['nombre']." su calificación es ".$estudiantes[4]['calificacion']."<br>";

            // 2. Usa una función para determinar si un estudiante aprueba (nota mayor o igual a 60).

            echo "<h4 class='mt-5'>2. Usa una función para determinar si un estudiante aprueba (nota mayor o igual a 60).</h4>";
            echo "<hr>";

            function estaAprobado($calificacion){
                return $calificacion >=60;
            }


            // Variables para almacenar datos
            $aprobados = [];
            $sumaCalificaciones = 0;

            // Recorrer el array de estudiantes
            foreach ($estudiantes as $estudiante) {
                $nombre = $estudiante["nombre"];
                $calificacion = $estudiante["calificacion"];
                $sumaCalificaciones += $calificacion;

                // Verificar si el estudiante aprueba
                if (estaAprobado($calificacion)) {
                    $aprobados[] = $nombre; // Agregar a la lista de aprobados
                    echo "$nombre ha aprobado con una calificación de $calificacion.<br>";
                } else {
                    echo "$nombre ha reprobado con una calificación de $calificacion.<br>";
                }
            }


            echo "<h4 class='mt-5'>3. Calcular el promedio general.</h4>";
            echo "<hr>";

            $promedio =  $sumaCalificaciones / count($estudiantes);

            // Mostrar el promedio y los aprobados
            echo "<br>El promedio general del grupo es: $promedio.<br>";
            echo "Estudiantes aprobados: " . implode(", ", $aprobados) . ".";

        ?>



        </section>
        <!-- Incluir JS de BOOTSTRAP -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

