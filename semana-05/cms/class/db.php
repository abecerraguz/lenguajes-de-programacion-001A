<?php
// Modo estricto: PHP no convierte tipos automáticamente.
// Si una función espera un int y le pasas un string, lanza un error.
declare(strict_types=1);

class db {

    // $conexionBD → guarda la conexión activa a la base de datos (objeto mysqli).
    // El ? significa que puede ser null (antes de conectar o tras cerrar).
    protected ?mysqli $conexionBD;

    // $consultaPreparada → guarda la consulta SQL lista para ejecutarse.
    //
    // ANALOGÍA: imagina que vas al supermercado. Antes de salir escribes
    // una lista de compras en un papel. Ese papel es la "consulta preparada":
    // ya tienes todo listo, solo falta ir a ejecutarla (hacer las compras).
    //
    // ¿Por qué no ejecutar el SQL directo sin preparar?
    // Porque prepararlo primero PROTEGE contra ataques. Si un usuario
    // escribe "1 OR 1=1" como dato, la consulta preparada lo trata como
    // texto plano y no como código SQL. Eso se llama evitar INYECCIÓN SQL.
    //
    // Desglose de la declaración:
    //   protected   → solo esta clase (y sus hijas) pueden usar esta variable.
    //                 Desde fuera del archivo no se puede tocar directamente.
    //   ?           → el signo ? significa que puede estar VACÍA (null).
    //                 Al inicio todavía no hay ninguna consulta preparada.
    //   mysqli_stmt → es el tipo de objeto que PHP usa para guardar una
    //                 consulta preparada. "stmt" viene de statement (instrucción).
    //   $consultaPreparada → nombre de la variable donde se guarda la consulta.
    //
    // Ciclo de vida de esta variable:
    //   1. Escribes el SQL:    "SELECT * FROM posts WHERE id = ?"
    //   2. PHP lo prepara:     revisa que esté bien escrito → se guarda aquí
    //   3. Le pasas el valor:  el ? se reemplaza por el número real (ej: 5)
    //   4. Se ejecuta:         la base de datos responde con los datos
    //   5. Se cierra:          se libera de la memoria → vuelve a ser null
    protected ?mysqli_stmt $consultaPreparada;

    // $mostrarErrores → si es true, los errores se muestran en pantalla y detienen el programa.
    protected bool $mostrarErrores = true;

    // $consultaCerrada → indica si la consulta actual ya fue cerrada (liberada de memoria).
    // Empieza en true porque al inicio no hay ninguna consulta abierta.
    protected bool $consultaCerrada = true;

    // $totalConsultas → contador de cuántas consultas se han ejecutado en esta conexión.
    public int $totalConsultas = 0;

    // ─── CONSTRUCTOR ────────────────────────────────────────────────────────────
    // Se ejecuta automáticamente al hacer: $db = new db(...)
    // Recibe los datos de conexión. Si no se pasan, usa los valores por defecto.
    public function __construct(
        string $servidorBD   = 'localhost', // servidor donde está MySQL (casi siempre localhost)
        string $usuarioBD    = 'root',      // usuario de la base de datos
        string $contrasenaBD = '',          // contraseña (vacía por defecto en entornos locales)
        string $nombreBD     = '',          // nombre de la base de datos a usar
        string $codificacion = 'utf8'       // codificación de caracteres (utf8 soporta tildes, ñ, etc.)
    ) {
        // Abre la conexión con los datos recibidos
        $this->conexionBD = new mysqli($servidorBD, $usuarioBD, $contrasenaBD, $nombreBD);

        // Si la conexión falló, muestra el error y detiene el programa
        if ($this->conexionBD->connect_error) {
            $this->error('No se pudo conectar a MySQL - ' . $this->conexionBD->connect_error);
        }

        // Establece la codificación para que los textos con tildes o ñ no se dañen
        $this->conexionBD->set_charset($codificacion);
    }

    // ─── QUERY ──────────────────────────────────────────────────────────────────
    // Prepara y ejecuta una consulta SQL.
    //
    // Uso básico:  $db->query("SELECT * FROM posts")
    // Con valores: $db->query("SELECT * FROM posts WHERE id = ?", $id)
    //              Los ? son marcadores seguros que evitan inyección SQL.
    //
    // ¿Por qué retorna "static" y no "void" o simplemente nada?
    // ----------------------------------------------------------
    // Porque al retornar el propio objeto ($this), podemos encadenar métodos
    // en una sola línea, en lugar de escribir dos líneas separadas:
    //
    //   SIN encadenamiento (2 líneas):
    //     $db->query("SELECT * FROM posts");
    //     $filas = $db->fetchAll();
    //
    //   CON encadenamiento gracias a "static" (1 línea):
    //     $filas = $db->query("SELECT * FROM posts")->fetchAll();
    //
    // ¿Por qué "static" y no ": db" (el nombre de la clase)?
    // -------------------------------------------------------
    // "static" significa "retorna una instancia de la clase ACTUAL".
    // Si alguien crea una clase hija que extiende db, el retorno seguirá
    // siendo la clase hija. Con ": db" quedaría atado a la clase padre.
    //   Ejemplo:
    //     class miDB extends db { ... }
    //     $resultado = (new miDB())->query("...")->fetchAll();
    //     // con static → retorna miDB ✅
    //     // con db     → retorna db   (pierde los métodos extra de miDB) ⚠️
    public function query(string $sentenciaSQL): static {

        // Si hay una consulta anterior abierta, la cerramos antes de continuar
        if (!$this->consultaCerrada) {
            $this->consultaPreparada->close();
        }

        // Prepara la consulta SQL (detecta errores de sintaxis antes de ejecutar)
        if ($this->consultaPreparada = $this->conexionBD->prepare($sentenciaSQL)) {

            // Si se pasaron valores extra (los ?) los vinculamos a la consulta
            if (func_num_args() > 1) {
                $todosLosArgumentos  = func_get_args();
                $valoresParaBind     = array_slice($todosLosArgumentos, 1); // toma solo los valores (sin el SQL)
                $cadenaDetipos       = '';
                $referenciasDeValores = [];

                // Recorre cada valor y detecta su tipo (s=string, i=int, d=float, b=otro)
                foreach ($valoresParaBind as $indice => &$valorActual) {
                    if (is_array($valoresParaBind[$indice])) {
                        // Si el valor es un array, procesa cada elemento dentro
                        foreach ($valoresParaBind[$indice] as $subIndice => &$subValor) {
                            $cadenaDetipos         .= $this->_gettype($valoresParaBind[$indice][$subIndice]);
                            $referenciasDeValores[] = &$subValor;
                        }
                    } else {
                        $cadenaDetipos         .= $this->_gettype($valoresParaBind[$indice]);
                        $referenciasDeValores[] = &$valorActual;
                    }
                }

                // Agrega la cadena de tipos al inicio del array (requisito de bind_param)
                array_unshift($referenciasDeValores, $cadenaDetipos);

                // Vincula los valores a los ? de la consulta de forma segura
                call_user_func_array([$this->consultaPreparada, 'bind_param'], $referenciasDeValores);
            }

            // Ejecuta la consulta ya preparada
            $this->consultaPreparada->execute();

            // Si hubo un error al ejecutar, lo muestra y detiene el programa
            if ($this->consultaPreparada->errno) {
                $this->error('No se puede procesar la consulta de MySQL (revisa tus parámetros) - ' . $this->consultaPreparada->error);
            }

            $this->consultaCerrada = false; // marcamos que hay una consulta abierta
            $this->totalConsultas++;        // sumamos al contador de consultas ejecutadas

        } else {
            // Si la preparación falló (SQL mal escrito), muestra el error
            $this->error('No se puede preparar la declaración de MySQL (revisa tu sintaxis) - ' . $this->conexionBD->error);
        }

        // Retorna $this para poder encadenar: ->query(...)->fetchAll()
        return $this;
    }

    // ─── FETCHALL ───────────────────────────────────────────────────────────────
    // Devuelve TODOS los resultados de la consulta como un array de arrays.
    // Cada elemento del array es una fila de la tabla.
    // Uso: $filas = $db->query("SELECT * FROM posts")->fetchAll()
    //
    // También acepta una función de callback opcional que se ejecuta por cada fila.
    // Si esa función retorna 'break', se detiene el recorrido antes de terminar.
    public function fetchAll(?callable $funcionPorFila = null): array {
        $referenciasColumnas = [];
        $filaActual          = [];

        // Obtiene la información de las columnas que trae la consulta
        $metadatosConsulta = $this->consultaPreparada->result_metadata();
        while ($columna = $metadatosConsulta->fetch_field()) {
            // Crea referencias a cada columna para leer los valores fila por fila
            $referenciasColumnas[] = &$filaActual[$columna->name];
        }

        // Vincula las referencias a los resultados de la consulta
        call_user_func_array([$this->consultaPreparada, 'bind_result'], $referenciasColumnas);

        $todasLasFilas = [];
        while ($this->consultaPreparada->fetch()) {
            // Copia los valores de la fila actual (necesario porque $filaActual usa referencias)
            $filaCopia = [];
            foreach ($filaActual as $nombreColumna => $valorColumna) {
                $filaCopia[$nombreColumna] = $valorColumna;
            }

            if ($funcionPorFila !== null) {
                // Si hay callback, ejecuta la función con la fila actual
                $resultadoCallback = call_user_func($funcionPorFila, $filaCopia);
                if ($resultadoCallback === 'break') {
                    break; // el callback pidió detener el recorrido
                }
            } else {
                // Sin callback, simplemente acumula la fila en el resultado
                $todasLasFilas[] = $filaCopia;
            }
        }

        $this->consultaPreparada->close(); // libera la consulta de la memoria
        $this->consultaCerrada = true;     // marcamos que ya no hay consulta abierta
        return $todasLasFilas;
    }

    // ─── FETCHARRAY ─────────────────────────────────────────────────────────────
    // Devuelve UNA SOLA fila como array asociativo (clave => valor).
    // Útil cuando sabes que la consulta devuelve un único registro.
    // Uso: $post = $db->query("SELECT * FROM posts WHERE id = ?", $id)->fetchArray()
    public function fetchArray(): array {
        $referenciasColumnas = [];
        $filaActual          = [];

        $metadatosConsulta = $this->consultaPreparada->result_metadata();
        while ($columna = $metadatosConsulta->fetch_field()) {
            $referenciasColumnas[] = &$filaActual[$columna->name];
        }

        call_user_func_array([$this->consultaPreparada, 'bind_result'], $referenciasColumnas);

        $filaResultado = [];
        while ($this->consultaPreparada->fetch()) {
            // Sobreescribe $filaResultado con la última fila leída
            foreach ($filaActual as $nombreColumna => $valorColumna) {
                $filaResultado[$nombreColumna] = $valorColumna;
            }
        }

        $this->consultaPreparada->close();
        $this->consultaCerrada = true;
        return $filaResultado;
    }

    // ─── CLOSE ──────────────────────────────────────────────────────────────────
    // Cierra la conexión a la base de datos y libera los recursos del servidor.
    // Llámala cuando ya no necesites hacer más consultas.
    public function close(): bool {
        return $this->conexionBD->close();
    }

    // ─── NUMROWS ────────────────────────────────────────────────────────────────
    // Devuelve cuántas filas trajo la última consulta SELECT.
    // Uso: $total = $db->query("SELECT * FROM posts")->numRows()
    public function numRows(): int {
        $this->consultaPreparada->store_result(); // necesario para poder leer num_rows
        return $this->consultaPreparada->num_rows;
    }

    // ─── AFFECTEDROWS ───────────────────────────────────────────────────────────
    // Devuelve cuántas filas fueron modificadas por el último INSERT, UPDATE o DELETE.
    // Útil para saber si realmente se guardó o eliminó algo.
    public function affectedRows(): int {
        return $this->consultaPreparada->affected_rows;
    }

    // ─── LASTINSERTID ───────────────────────────────────────────────────────────
    // Devuelve el ID generado automáticamente por el último INSERT.
    // Útil para saber el id del registro recién creado.
    public function lastInsertID(): int {
        return $this->conexionBD->insert_id;
    }

    // ─── ERROR ──────────────────────────────────────────────────────────────────
    // Muestra un mensaje de error y detiene la ejecución del programa.
    // Solo actúa si $mostrarErrores es true.
    public function error(string $mensajeError): void {
        if ($this->mostrarErrores) {
            exit($mensajeError);
        }
    }

    // ─── _GETTYPE ───────────────────────────────────────────────────────────────
    // Método privado (solo lo usa esta clase internamente).
    // Detecta el tipo de un valor y devuelve la letra que usa bind_param:
    //   's' → string (texto)
    //   'd' → float  (decimal)
    //   'i' → int    (entero)
    //   'b' → blob   (cualquier otro tipo / binario)
    private function _gettype(mixed $valorADetectar): string {
        if (is_string($valorADetectar)) return 's';
        if (is_float($valorADetectar))  return 'd';
        if (is_int($valorADetectar))    return 'i';
        return 'b';
    }

}
?>


class db {

    // $connection → guarda la conexión activa a la base de datos (objeto mysqli).
    // El ? significa que puede ser null (antes de conectar o tras cerrar).
    protected ?mysqli $connection;

    // $query → guarda la consulta preparada lista para ejecutarse (objeto mysqli_stmt).
    // También puede ser null si aún no se ha preparado ninguna consulta.
    protected ?mysqli_stmt $query;

    // $show_errors → si es true, los errores se muestran en pantalla y detienen el programa.
    protected bool $show_errors = true;

    // $query_closed → indica si la consulta actual ya fue cerrada (liberada de memoria).
    // Empieza en true porque al inicio no hay ninguna consulta abierta.
    protected bool $query_closed = true;

    // $query_count → contador de cuántas consultas se han ejecutado en esta conexión.
    public int $query_count = 0;

    // ─── CONSTRUCTOR ────────────────────────────────────────────────────────────
    // Se ejecuta automáticamente al hacer: $db = new db(...)
    // Recibe los datos de conexión. Si no se pasan, usa los valores por defecto.
    public function __construct(
        string $dbhost  = 'localhost', // servidor donde está MySQL (casi siempre localhost)
        string $dbuser  = 'root',      // usuario de la base de datos
        string $dbpass  = '',          // contraseña (vacía por defecto en entornos locales)
        string $dbname  = '',          // nombre de la base de datos a usar
        string $charset = 'utf8'       // codificación de caracteres (utf8 soporta tildes, ñ, etc.)
    ) {
        // Abre la conexión con los datos recibidos
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        // Si la conexión falló, muestra el error y detiene el programa
        if ($this->connection->connect_error) {
            $this->error('No se pudo conectar a MySQL - ' . $this->connection->connect_error);
        }

        // Establece la codificación para que los textos con tildes o ñ no se dañen
        $this->connection->set_charset($charset);
    }

    // ─── QUERY ──────────────────────────────────────────────────────────────────
    // Prepara y ejecuta una consulta SQL.
    // Uso básico:  $db->query("SELECT * FROM usuarios")
    // Con valores: $db->query("SELECT * FROM usuarios WHERE id = ?", $id)
    // Los ? son marcadores seguros que evitan inyección SQL.
    // Retorna $this para poder encadenar métodos: $db->query(...)->fetchAll()
    public function query(string $query): static {

        // Si hay una consulta anterior abierta, la cerramos antes de continuar
        if (!$this->query_closed) {
            $this->query->close();
        }

        // Prepara la consulta SQL (detecta errores de sintaxis antes de ejecutar)
        if ($this->query = $this->connection->prepare($query)) {

            // Si se pasaron valores extra (los ?) los vinculamos a la consulta
            if (func_num_args() > 1) {
                $x        = func_get_args();
                $args     = array_slice($x, 1); // toma solo los valores extra (sin el SQL)
                $types    = '';
                $args_ref = [];

                // Recorre cada valor y detecta su tipo (s=string, i=int, d=float, b=otro)
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        // Si el valor es un array, procesa cada elemento dentro
                        foreach ($args[$k] as $j => &$a) {
                            $types     .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types     .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }

                // Agrega la cadena de tipos al inicio del array (requisito de bind_param)
                array_unshift($args_ref, $types);

                // Vincula los valores a los ? de la consulta de forma segura
                call_user_func_array([$this->query, 'bind_param'], $args_ref);
            }

            // Ejecuta la consulta ya preparada
            $this->query->execute();

            // Si hubo un error al ejecutar, lo muestra y detiene el programa
            if ($this->query->errno) {
                $this->error('No se puede procesar la consulta de MySQL (revisa tus parámetros) - ' . $this->query->error);
            }

            $this->query_closed = false; // marcamos que hay una consulta abierta
            $this->query_count++;        // sumamos al contador de consultas ejecutadas

        } else {
            // Si la preparación falló (SQL mal escrito), muestra el error
            $this->error('No se puede preparar la declaración de MySQL (revisa tu sintaxis) - ' . $this->connection->error);
        }

        // Retorna $this para poder encadenar: ->query(...)->fetchAll()
        return $this;
    }

    // ─── FETCHALL ───────────────────────────────────────────────────────────────
    // Devuelve TODOS los resultados de la consulta como un array de arrays.
    // Cada elemento del array es una fila de la tabla.
    // Uso: $filas = $db->query("SELECT * FROM posts")->fetchAll()
    //
    // También acepta una función de callback opcional que se ejecuta por cada fila.
    // Si esa función retorna 'break', se detiene el recorrido antes de terminar.
    public function fetchAll(?callable $callback = null): array {
        $params = [];
        $row    = [];

        // Obtiene la información de las columnas que trae la consulta
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            // Crea referencias a cada columna para leer los valores fila por fila
            $params[] = &$row[$field->name];
        }

        // Vincula las referencias a los resultados de la consulta
        call_user_func_array([$this->query, 'bind_result'], $params);

        $result = [];
        while ($this->query->fetch()) {
            // Copia los valores de la fila actual (necesario porque $row usa referencias)
            $r = [];
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }

            if ($callback !== null) {
                // Si hay callback, ejecuta la función con la fila actual
                $value = call_user_func($callback, $r);
                if ($value === 'break') {
                    break; // el callback pidió detener el recorrido
                }
            } else {
                // Sin callback, simplemente acumula la fila en el resultado
                $result[] = $r;
            }
        }

        $this->query->close();       // libera la consulta de la memoria
        $this->query_closed = true;  // marcamos que ya no hay consulta abierta
        return $result;
    }

    // ─── FETCHARRAY ─────────────────────────────────────────────────────────────
    // Devuelve UNA SOLA fila como array asociativo (clave => valor).
    // Útil cuando sabes que la consulta devuelve un único registro.
    // Uso: $post = $db->query("SELECT * FROM posts WHERE id = ?", $id)->fetchArray()
    public function fetchArray(): array {
        $params = [];
        $row    = [];

        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array([$this->query, 'bind_result'], $params);

        $result = [];
        while ($this->query->fetch()) {
            // Sobreescribe $result con la última fila leída
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }

        $this->query->close();
        $this->query_closed = true;
        return $result;
    }

    // ─── CLOSE ──────────────────────────────────────────────────────────────────
    // Cierra la conexión a la base de datos y libera los recursos del servidor.
    // Llámala cuando ya no necesites hacer más consultas.
    public function close(): bool {
        return $this->connection->close();
    }

    // ─── NUMROWS ────────────────────────────────────────────────────────────────
    // Devuelve cuántas filas trajo la última consulta SELECT.
    // Uso: $total = $db->query("SELECT * FROM posts")->numRows()
    public function numRows(): int {
        $this->query->store_result(); // necesario para poder leer num_rows
        return $this->query->num_rows;
    }

    // ─── AFFECTEDROWS ───────────────────────────────────────────────────────────
    // Devuelve cuántas filas fueron modificadas por el último INSERT, UPDATE o DELETE.
    // Útil para saber si realmente se guardó o eliminó algo.
    public function affectedRows(): int {
        return $this->query->affected_rows;
    }

    // ─── LASTINSERTID ───────────────────────────────────────────────────────────
    // Devuelve el ID generado automáticamente por el último INSERT.
    // Útil para saber el id del registro recién creado.
    public function lastInsertID(): int {
        return $this->connection->insert_id;
    }

    // ─── ERROR ──────────────────────────────────────────────────────────────────
    // Muestra un mensaje de error y detiene la ejecución del programa.
    // Solo actúa si $show_errors es true.
    public function error(string $error): void {
        if ($this->show_errors) {
            exit($error);
        }
    }

    // ─── _GETTYPE ───────────────────────────────────────────────────────────────
    // Método privado (solo lo usa esta clase internamente).
    // Detecta el tipo de un valor y devuelve la letra que usa bind_param:
    //   's' → string (texto)
    //   'd' → float  (decimal)
    //   'i' → int    (entero)
    //   'b' → blob   (cualquier otro tipo / binario)
    private function _gettype(mixed $var): string {
        if (is_string($var)) return 's';
        if (is_float($var))  return 'd';
        if (is_int($var))    return 'i';
        return 'b';
    }

}
?>
