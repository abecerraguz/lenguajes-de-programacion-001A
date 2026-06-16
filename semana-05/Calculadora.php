<?php

// ============================================================
// TIPADO ESTRICTO
// Obliga a PHP a respetar los tipos declarados.
// Si se pasa un tipo incorrecto, PHP lanzará un error.
// Siempre debe ir en la primera línea del archivo.
// ============================================================
declare(strict_types=1);

// ============================================================
// DEFINICIÓN DE LA CLASE
// La clase Calculadora agrupa todas las operaciones matemáticas
// básicas en un solo lugar. Cada operación es un método.
// ============================================================
class Calculadora{
    // --------------------------------------------------------
    // PROPIEDADES
    // Esta calculadora guarda el historial del último resultado
    // obtenido. Es private porque no tiene sentido que se
    // modifique desde fuera de la clase directamente.
    // --------------------------------------------------------
    private float $ultimoResultado;

    // --------------------------------------------------------
    // CONSTRUCTOR
    // Inicializa el último resultado en 0.0 al crear el objeto.
    // No recibe parámetros porque una calculadora parte siempre
    // desde cero.
    // --------------------------------------------------------
    public function __construct(){
        $this->ultimoResultado = 0.0;
    }

    // --------------------------------------------------------
    // MÉTODO: sumar
    // Recibe dos números (int o float) y retorna su suma.
    //
    // Tipo de retorno float → siempre devuelve un decimal,
    // lo que permite manejar tanto enteros como decimales
    // sin perder precisión.
    // --------------------------------------------------------
    public function sumar(float $a, float $b): float{
        $this->ultimoResultado = $a + $b;
        return $this->ultimoResultado;
    }

    // --------------------------------------------------------
    // MÉTODO: restar
    // Recibe dos números y retorna la diferencia entre ellos.
    // --------------------------------------------------------
    public function restar(float $a, float $b): float{
        $this->ultimoResultado = $a - $b;
        return $this->ultimoResultado;
    }

    // --------------------------------------------------------
    // MÉTODO: multiplicar
    // Recibe dos números y retorna su producto.
    // --------------------------------------------------------
    public function multiplicar(float $a, float $b): float{
        $this->ultimoResultado = $a * $b;
        return $this->ultimoResultado;
    }

    // --------------------------------------------------------
    // MÉTODO: dividir
    // Recibe dos números y retorna el cociente.
    //
    // CASO ESPECIAL: dividir por cero es matemáticamente
    // imposible. Por eso se valida antes de operar.
    // Si $b es 0, se retorna null en vez de un resultado.
    //
    // Tipo de retorno ?float → el "?" indica que puede retornar
    // float O null (tipo nullable). Esto es parte del tipado
    // estricto de PHP para manejar casos sin valor válido.
    // --------------------------------------------------------
    public function dividir(float $a, float $b): ?float{
        if ($b === 0.0) {
            echo "⚠️ Error: No se puede dividir por cero.<br>";
            return null;
        }

        $this->ultimoResultado = $a / $b;
        return $this->ultimoResultado;
    }

    // --------------------------------------------------------
    // MÉTODO: obtenerUltimoResultado
    // Permite leer la propiedad privada $ultimoResultado
    // desde fuera de la clase de forma controlada.
    // Este patrón se llama "getter".
    // --------------------------------------------------------
    public function obtenerUltimoResultado(): float{
        return $this->ultimoResultado;
    }
}


// ============================================================
// INSTANCIACIÓN
// Se crea un único objeto calculadora. A diferencia de Persona,
// no necesitamos múltiples instancias: una calculadora alcanza.
// ============================================================
$calc = new Calculadora();


// ============================================================
// USO DE LOS MÉTODOS
// Llamamos a cada operación y mostramos su resultado.
// ============================================================

$resultado = $calc->sumar(10, 5);
echo "Suma:           10 + 5  = {$resultado}<br>";

$resultado = $calc->restar(10, 5);
echo "Resta:          10 - 5  = {$resultado}<br>";

$resultado = $calc->multiplicar(10, 5);
echo "Multiplicación: 10 × 5  = {$resultado}<br>";

$resultado = $calc->dividir(10, 5);
echo "División:       10 ÷ 5  = {$resultado}<br>";

echo "<br>";

// Caso especial: división por cero
$resultado = $calc->dividir(10, 0);
echo "Resultado obtenido: " . ($resultado ?? "sin resultado") . "<br>";

echo "<br>";

// Consultar el último resultado guardado usando el getter
$ultimo = $calc->obtenerUltimoResultado();
echo "Último resultado válido guardado: {$ultimo}<br>";