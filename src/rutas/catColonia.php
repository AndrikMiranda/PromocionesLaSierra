<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Las Colonias
$app -> get('/api/catColonia', function(Request $request, Response $response){

     $consulta = "select * from cat_colonia";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catColonia = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            //Exportar y mostrar JSON
            echo json_encode($catColonia);
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Colonia en especifico
$app -> get('/api/catColonia/{NomColonia}', function(Request $request, Response $response){

    $NombreColonia = $request -> getAttribute('NomColonia');
    
      $consulta = "select * from cat_colonia WHERE NomColonia LIKE '%$NombreColonia%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catColonia = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($catColonia);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Colonia
    $app -> post('/api/catColonia/agregar', function(Request $request, Response $response){

        $NombreColonia = $request -> getParam('NomColonia');
        $CP = $request -> getParam('CP');
         
          $consulta = "INSERT INTO cat_colonia(NomColonia,CP)
                       values (:NomColonia, :CP )";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':NomColonia', $NombreColonia);
              $stmt -> bindParam(':CP', $CP);
              $stmt -> execute();
              echo '{"notice": {"text": "Colonia agregada"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

         //Actualizar Colonia
    $app -> put('/api/catColonia/actualizar/{IdColonia}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdColonia');
        $NombreColonia = $request -> getParam('NomColonia');
        $CP = $request -> getParam('CP');
      
      
        $consulta = "UPDATE cat_colonia SET
                     NomColonia = :NomColonia,
                     CP = :CP
                     WHERE IdColonia = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':NomColonia', $NombreColonia);
            $stmt -> bindParam(':CP', $CP);
            $stmt -> execute();
            echo '{"notice": {"text": "Colonia actualizada"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

      //Eliminar Colonia
    $app -> delete('/api/catColonia/eliminar/{IdColonia}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdColonia');
        
          $consulta = "DELETE FROM cat_colonia WHERE IdColonia = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Colonia borrada"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>