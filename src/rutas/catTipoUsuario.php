<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Obtener Tipo Usuario
$app -> get('/api/tipousuario', function(Request $request, Response $response){

    $consulta = "SELECT IdTipoUsuario,TipoUsuario
                 FROM cat_tipousuario
                 ORDER BY IdTipoUsuario";
 
    try {
 
          //Instanciacion de base de datos
           $db = new db();
           $db = $db -> conectar();
           $ejecutar = $db -> query($consulta);
           $Tusuario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
           $db = null;
 
           //Exportar y mostrar JSON
           echo json_encode($Tusuario, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 
       } catch (PDOException $e) {
           echo '{"error": {"text": '.$e -> getMessage().'}';
       }
 
});

//obtener Motivo en especifico
$app -> get('/api/tipousuario/{TipoUsuario}', function(Request $request, Response $response){

    $TipoUsuario = $request -> getAttribute('TipoUsuario');
    
      $consulta = "SELECT IdTipoUsuario,TipoUsuario
                   FROM cat_tipousuario
                   WHERE TipoUsuario LIKE '%$TipoUsuario%'
                   ORDER BY IdTipoUsuario;";
    
      try {
    
        //Instanciacion de base de datos
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consulta);
          $Tusuario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
    
          //Exportar y mostrar JSON
          echo json_encode($Tusuario, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    
      } catch (PDOException $e) {
        echo '{"error": {"text": '.$e -> getMessage().'}';
      }
    
    
    });

//Agregar Tipo de Usuario
    $app -> post('/api/tipousuario/agregar', function(Request $request, Response $response){

        $TipoUsuario = $request -> getParam('TipoUsuario');
        
         
          $consulta = "INSERT INTO cat_tipousuario(TipoUsuario)
                       values (:TipoUsuario)";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> prepare($consulta);
              $stmt -> bindParam(':TipoUsuario', $TipoUsuario);
              $stmt -> execute();
              echo '{"notice": {"text": "Tipo de Usuario Agregado"}';
              //Exportar y mostrar JSON
        
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });

          //Actualizar Tipo de Usuario
        $app -> put('/api/tipousuario/actualizar/{IdTipoUsuario}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdTipoUsuario');
        $TipoMotivo = $request -> getParam('TipoUsuario');
      
        $consulta = "UPDATE cat_tipousuario SET
                     TipoUsuario = :TipoUsuario
                     WHERE IdTipoUsuario = $id";
      
        try {
      
          //Instanciacion de base de datos
            $db = new db();
            $db = $db -> conectar();
            $stmt = $db -> prepare($consulta);
            $stmt -> bindParam(':TipoUsuario', $TipoMotivo);
            $stmt -> execute();
            echo '{"notice": {"text": "Tipo de Usuario actualizado"}';
            //Exportar y mostrar JSON
      
        } catch (PDOException $e) {
          echo '{"error": {"text": '.$e -> getMessage().'}';
        }
      
      });

              //Eliminar Tipo de Usuario
    $app -> delete('/api/tipousuario/eliminar/{IdTipoUsuario}', function(Request $request, Response $response){

        $id = $request -> getAttribute('IdTipoUsuario');
        
          $consulta = "DELETE FROM cat_tipousuario WHERE IdTipoUsuario = $id;";
        
          try {
        
            //Instanciacion de base de datos
              $db = new db();
              $db = $db -> conectar();
              $stmt = $db -> query($consulta);
              $stmt -> execute();
              $db = null;
              echo '{"notice": {"text": "Tipo de Usuario Eliminado"}';
          } catch (PDOException $e) {
            echo '{"error": {"text": '.$e -> getMessage().'}';
          }
        
        
        });