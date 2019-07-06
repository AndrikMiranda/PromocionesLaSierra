<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Los Estados
$app -> get('/api/catEstado', function(Request $request, Response $response){

     $consulta = "select * from cat_estado";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catestado = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            //Exportar y mostrar JSON
            echo json_encode($catestado);
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Estado en especifico
$app -> get('/api/catEstado/{NomEstado}', function(Request $request, Response $response){

    $NombEstado = $request -> getAttribute('NomEstado');
    
      $consulta = "select * from cat_estado WHERE NomEstado LIKE '%$NombEstado%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catestado = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($catestado);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Estado
    $app -> post('/api/catEstado/agregar', function(Request $request, Response $response){

        $NombEstado = $request -> getParam('NomEstado');
         
          $consulta = "INSERT INTO cat_estado(NomEstado)
                       values (:NomEstado)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':NomEstado', $NombEstado);
              $stmt -> execute();
              echo '{"notice": {"text": "Estado agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

         //Actualizar Estado
    $app -> put('/api/catEstado/actualizar/{IdEstado}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdEstado');
        $NombEstado = $request -> getParam('NomEstado');
      
      
        $consulta = "UPDATE cat_estado SET
                     NomEstado = :NomEstado
                     WHERE IdEstado = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':NomEstado', $NombEstado);
            $stmt -> execute();
            echo '{"notice": {"text": "Estado actualizado"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

      //Eliminar Estado
    $app -> delete('/api/catEstado/eliminar/{IdEstado}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdEstado');
        
          $consulta = "DELETE FROM cat_estado WHERE IdEstado = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Estado borrado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>