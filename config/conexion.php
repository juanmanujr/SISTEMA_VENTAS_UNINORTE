<?php

// Clase encargada de realizar la conexión con la base de datos
class Conectar
{
    // Variable que almacenará la conexión PDO
    protected $dbh;

    // Método para establecer la conexión
    protected function Conexion()
    {
        try {
            // Crea una nueva conexión con MySQL mediante PDO
            $this->dbh = new PDO(
                "mysql:host=localhost;dbname=ventas",
                "root",
                ""
            );

            // Retorna la conexión establecida
            return $this->dbh;

        } catch (Exception $e) {

            // Muestra el mensaje si ocurre un error de conexión
            print "Error BD: " . $e->getMessage() . "<br/>";

            // Detiene la ejecución del programa
            die();
        }
    }

    // Método para configurar la codificación de caracteres
    public function set_names()
    {
        // Establece la codificación UTF-8 para la conexión
        return $this->dbh->query("SET NAMES 'utf8'");
    }
}

?>