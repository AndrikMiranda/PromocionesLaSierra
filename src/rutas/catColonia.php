<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Las Colonias
$app -> get('/api/catColonia', function(Request $request, Response $response){


  $limit = $request -> getParam('limit');
  $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;

  $count = "SELECT COUNT(*) as Total FROM cat_colonia";

     $consulta = "select * from cat_colonia";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catColonia = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            $db = new db();
            $db = $db->conectar();
            $ejecutar1 = $db -> query($count);
            $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
   
            if($catColonia) {
              return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write(json_encode($catColonia, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Colonia en especifico
$app -> get('/api/catColonia/', function(Request $request, Response $response){

    $NombreColonia = $request -> getParam('NomColonia');
    
      $consulta = "select * from cat_colonia WHERE NomColonia LIKE '%$NombreColonia%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catColonia = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          if($catColonia) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($catColonia, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
          }
    
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

              if($stmt) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
              }
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

         //Actualizar Colonia
    $app -> put('/api/catColonia/actualizar/', function(Request $request, Response $response){

        $id = $request -> getParam('IdColonia');
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
            
            if($stmt) {
              return $response->withStatus(201)
                  ->withHeader('Content-Type', 'application/json')
                  ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

      //Eliminar Colonia
    $app -> delete('/api/catColonia/eliminar/', function(Request $request, Response $response){

        $id = $request -> getParam('IdColonia');
        
          $consulta = "DELETE FROM cat_colonia WHERE IdColonia = $id";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;

              if($stmt) {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
              }

          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>