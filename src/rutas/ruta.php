<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Ruta
$app -> get('/api/ruta', function(Request $request, Response $response){

<<<<<<< HEAD
    $consulta = "SELECT a.IdRuta,a.NumeroRuta,b.NomColonia,b.CP
                 FROM ruta a, cat_colonia b
                 WHERE a.FkColonia = b.IdColonia
                 ORDER BY IdRuta";
=======
    $consulta = "SELECT
                ruta.IdRuta,
                ruta.NumeroRuta,
                ruta.FkColonia,
                cat_colonia.NomColonia,
                cat_colonia.CP
                FROM
                ruta
                INNER JOIN cat_colonia ON ruta.FkColonia = cat_colonia.IdColonia
                ORDER BY ruta.IdRuta";
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Ruta = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//Obtener Ruta Especifica
$app -> get('/api/ruta/{NumeroRuta}', function(Request $request, Response $response){

    $NumeroRuta = $request -> getAttribute('NumeroRuta');
<<<<<<< HEAD
    
      $consulta = "SELECT a.IdRuta,a.NumeroRuta,b.NomColonia,b.CP
                   FROM ruta a, cat_colonia b
                   WHERE a.FkColonia = b.IdColonia 
                   AND NumeroRuta LIKE '%$NumeroRuta%'
                   ORDER BY IdRuta";
=======

    $consulta = "SELECT
                ruta.IdRuta,
                ruta.NumeroRuta,
                ruta.FkColonia,
                cat_colonia.NomColonia,
                cat_colonia.CP
                FROM
                ruta
                INNER JOIN cat_colonia ON ruta.FkColonia = cat_colonia.IdColonia
                where ruta.NumeroRuta = '$NumeroRuta'
                ORDER BY ruta.IdRuta";    
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Ruta = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($Ruta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

//Agregar Ruta
    $app -> post('/api/ruta/agregar', function(Request $request, Response $response){

        $NumeroRuta = $request -> getParam('NumeroRuta');
        $FkColonia = $request -> getParam('FkColonia');
        
<<<<<<< HEAD
         
          $consulta = "INSERT INTO ruta(NumeroRuta,FkColonia)
                       values (:NumeroRuta, :FkColonia)";
        
          try {
=======
        $consulta = "INSERT INTO ruta(NumeroRuta,FkColonia)
                       values (:NumeroRuta, :FkColonia)";
        
        try {
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
        
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

<<<<<<< HEAD
          //Actualizar Ruta
=======
        //Actualizar Ruta
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
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

              //Eliminar Ruta
    $app -> delete('/api/ruta/eliminar/{IdRuta}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdRuta');
        
          $consulta = "DELETE FROM ruta WHERE IdRuta = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Ruta Eliminada"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });