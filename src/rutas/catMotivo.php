<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Motivo
$app -> get('/api/motivo', function(Request $request, Response $response){

    $consulta = "SELECT IdMotivo,TipoMotivo
                 FROM cat_motivo
                 ORDER BY IdMotivo";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Motivo = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Motivo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//obtener Motivo en especifico
$app -> get('/api/motivo/{TipoMotivo}', function(Request $request, Response $response){

    $TipoMotivo = $request -> getAttribute('TipoMotivo');
    
      $consulta = "SELECT IdMotivo,TipoMotivo
                   FROM cat_motivo
                   WHERE TipoMotivo LIKE '%$TipoMotivo%'
                   ORDER BY IdMotivo;";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Motivo = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($Motivo);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

//Agregar Motivo
    $app -> post('/api/motivo/agregar', function(Request $request, Response $response){

        $TipoMotivo = $request -> getParam('TipoMotivo');
        
         
          $consulta = "INSERT INTO cat_motivo(TipoMotivo)
                       values (:TipoMotivo)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':TipoMotivo', $TipoMotivo);
              $stmt -> execute();
              echo '{"notice": {"text": "Tipo de Motivo Agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

          //Actualizar Tipo de Motivo
        $app -> put('/api/motivo/actualizar/{IdMotivo}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdMotivo');
        $TipoMotivo = $request -> getParam('TipoMotivo');
      
        $consulta = "UPDATE cat_motivo SET
                     TipoMotivo = :TipoMotivo
                     WHERE IdMotivo = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':TipoMotivo', $TipoMotivo);
            $stmt -> execute();
            echo '{"notice": {"text": "Tipo de Motivo actualizado"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

              //Eliminar Tipo de Motivo
    $app -> delete('/api/motivo/eliminar/{IdMotivo}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdMotivo');
        
          $consulta = "DELETE FROM cat_motivo WHERE IdMotivo = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Tipo de Motivo Eliminado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });