<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Lio
$app -> get('/api/lio', function(Request $request, Response $response){

    $consulta = "SELECT IdLio,TipoLio
                 FROM cat_lio
                 ORDER BY IdLio";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Lio = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Lio, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//obtener Lio en especifico
$app -> get('/api/lio/{TipoLio}', function(Request $request, Response $response){

    $TipoLio = $request -> getAttribute('TipoLio');
    
      $consulta = "SELECT IdLio,TipoLio
                   FROM cat_lio
                   WHERE TipoLio LIKE '%$TipoLio%'
                   ORDER BY IdLio;";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Lio = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($Lio);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

//Agregar Lio
    $app -> post('/api/lio/agregar', function(Request $request, Response $response){

        $TipoLio = $request -> getParam('TipoLio');
        
         
          $consulta = "INSERT INTO cat_lio(TipoLio)
                       values (:TipoLio)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':TipoLio', $TipoLio);
              $stmt -> execute();
              echo '{"notice": {"text": "Tipo de Lio Agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

          //Actualizar Lio
        $app -> put('/api/lio/actualizar/{IdLio}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdLio');
        $TipoLio = $request -> getParam('TipoLio');
      
        $consulta = "UPDATE cat_lio SET
                     TipoLio = :TipoLio
                     WHERE IdLio = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':TipoLio', $TipoLio);
            $stmt -> execute();
            echo '{"notice": {"text": "Tipo de Lio actualizado"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

              //Eliminar Tipo de Lio
    $app -> delete('/api/lio/eliminar/{IdLio}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdLio');
        
          $consulta = "DELETE FROM cat_lio WHERE IdLio = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Tipo de Lio Eliminado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });