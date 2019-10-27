<?php
  class db{
<<<<<<< HEAD
      private $host = 'localhost';
      private $usuario = 'root';
      private $password = '';
      private $db = 'lasierra';
=======
      private $host = 'mysql-jherrera.alwaysdata.net';
      private $usuario = 'jherrera';
      private $password = 'Arthamis07';
      private $db = 'jherrera_lasierra';
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada


      public function conectar() {
        $conexion_mysql = "mysql:host=$this->host;dbname=$this->db";
        $conexionBD = new PDO($conexion_mysql, $this->usuario, $this->password);
        $conexionBD -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $conexionBD -> exec("set names utf8");

        return $conexionBD;

      }

  }


?>
