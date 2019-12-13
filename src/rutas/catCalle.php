<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Las Calles
$app -> get('/api/catCalle', function(Request $request, Response $response){

     $consulta = "select * from cat_calle";
  
     try {
  
           //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $ejecutar = $db -> query($consulta);
            $catcalle = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
            $db = null;
  
            //Exportar y mostrar JSON
            echo json_encode($catcalle);
  
        } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
        }
  
});

//Obtener Calle en especifico
$app -> get('/api/catCalle/{NombreCalle}', function(Request $request, Response $response){

    $NombreCalle = $request -> getAttribute('NombreCalle');
    
      $consulta = "select * from cat_calle WHERE NomCalle LIKE '%$NombreCalle%';";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $catcalle = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($catcalle);
    
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
              echo '{"notice": {"text": "Calle agregada"}';
              //Exportar y mostrar JSON
        
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
            echo '{"notice": {"text": "Calle actualizada"}';
            //Exportar y mostrar JSON
      
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
              echo '{"notice": {"text": "Calle eliminada
                "}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });
?>