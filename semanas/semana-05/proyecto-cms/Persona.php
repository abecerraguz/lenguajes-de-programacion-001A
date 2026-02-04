<?php 
   
    class Persona{

        public $nombre;
        public $edad; 

        //funcion construtora
        function __construct($nombre,$edad ){
            $this->nombre = $nombre;
            $this->edad = $edad;
        }

        //metodos
        public function saludar(){
            echo "Hola, mi nombre es {$this->nombre} y tengo {$this->edad} años";
        }


    }

    $persona1 = new Persona('Pedro', 25);
    $persona2  = new Persona('Maria', 28);

    echo $persona1->nombre."</br>";
    echo $persona1->edad."</br>";
    $persona1->saludar();

    echo "</br>";

    echo $persona2->nombre."</br>";
    echo $persona2->edad."</br>";
    $persona2->saludar();



?>