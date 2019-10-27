<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Agregar Ruta
    $app -> post('/api/login', function(Request $request, Response $response){

        $Usuario = $request -> getParam('Usuario');
        $Contrasena = $request -> getParam('Contrasena');
        
         
          $consulta = "INSERT INTO ruta(NumeroRuta,FkColonia)
                       values (:NumeroRuta, :FkColonia)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':NumeroRuta', $NumeroRuta);
              $stmt -> bindParam(':FkColonia', $FkColonia);
              $stmt -> execute();
              echo '{"notice": {"text": "Ruta Agregada"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

          //Actualizar Ruta
        $app -> put('/api/ruta/actualizar/{IdRuta}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdRuta');
        $NumeroRuta = $request -> getParam('NumeroRuta');
        $FkColonia = $request -> getParam('FkColonia');
      
        $consulta = "UPDATE ruta SET
                     NumeroRuta = :NumeroRuta,
                     FkColonia = :FkColonia
                     WHERE IdRuta = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':NumeroRuta', $NumeroRuta);
            $stmt -> bindParam(':FkColonia', $FkColonia);
            $stmt -> execute();
            echo '{"notice": {"text": "Ruta actualizada"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });
