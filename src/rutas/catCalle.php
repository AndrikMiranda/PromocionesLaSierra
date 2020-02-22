<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Las Calles
$app -> get('/api/catCalle', function(Request $request, Response $response){

     $consulta = "select * from cat_calle";

     $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
    
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;

    $count = "SELECT COUNT(*) as Total FROM cat_calle";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catcalle = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;

            $db = new db();
            $db = $db->conectar();
            $ejecutar1 = $db -> query($count);
            $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            if($catcalle) {
              return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write(json_encode($catcalle, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Calle en especifico con busqueda LIKE
$app -> get('/api/catCalle/', function(Request $request, Response $response){

    $NombreCalle = $request -> getParam('NombreCalle');
    
      $consulta = "select * from cat_calle WHERE NomCalle LIKE '%$NombreCalle%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catcalle = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    

          if($catcalle) {
            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($catcalle, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
          }

    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

    //Agregar Calle
    $app -> post('/api/catCalle/agregar', function(Request $request, Response $response){

        $NombreCalle = $request -> getParam('NomCalle');
        $lat = $request -> getParam('Latitud');
        $lon = $request -> getParam('Longitud');
         
          $consulta = "INSERT INTO cat_calle(NomCalle,Latitud,Longitud)
                       values (:NomCalle, :Latitud, :Longitud)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':NomCalle', $NombreCalle);
              $stmt -> bindParam(':Latitud', $lat);
              $stmt -> bindParam(':Longitud', $lon);
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

         //Actualizar Calle
    $app -> put('/api/catCalle/actualizar/{IdCalle}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdCalle');
        $NombreCalle = $request -> getParam('NomCalle');
        $lat = $request -> getParam('Latitud');
        $lon = $request -> getParam('Longitud');
      
      
        $consulta = "UPDATE cat_calle SET
                     NomCalle = :NomCalle,
                     Latitud = :Latitud,
                     Longitud = :Longitud
                     WHERE IdCalle = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':NomCalle', $NombreCalle);
            $stmt -> bindParam(':Latitud', $lat);
            $stmt -> bindParam(':Longitud', $lon);
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

      //Eliminar Calle
    $app -> delete('/api/catCalle/eliminar/{IdCalle}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdCalle');
        
          $consulta = "DELETE FROM cat_calle WHERE IdCalle = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;

              if($stmt) {
                return $response->withStatus(201)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
              }

          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>