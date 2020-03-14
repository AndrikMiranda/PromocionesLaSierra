<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app -> get('/api/usuarios/', function(Request $request, Response $response){
$mCustomHelper = new MyCustomHelper();

  $idUsuario = $request->getParam('idUser');
  $page = $request->getParam('page');
  $limit = $request->getParam('pageSize');
  $likeSearch = $request->getParam('likeSearch');
  $columnaGenerica = $request->getParam('columnaGenerica');
  $parametroColumnaGenerica = $request->getParam('parametroGenerico');

  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $pageForReturn = $pageReal;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $consultaGenerica = "SELECT
                    usuario.Nombre,
                    cat_tipousuario.TipoUsuario,
                    cat_estatus_usuarios.Estatus,
                    cat_estatus_usuarios.Descripcion,
                    usuario.IdUsuario
                    FROM
                    usuario
                    INNER JOIN cat_estatus_usuarios ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
                    INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $totalConsultaGenerica = "SELECT
                    usuario.Nombre,
                    cat_tipousuario.TipoUsuario,
                    cat_estatus_usuarios.Estatus,
                    cat_estatus_usuarios.Descripcion,
                    usuario.IdUsuario
                    FROM
                    usuario
                    INNER JOIN cat_estatus_usuarios ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
                    INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
                    LIMIT $limit
                    OFFSET $offset";
  
  $consultaTodos = "SELECT
                    usuario.Nombre,
                    cat_tipousuario.TipoUsuario,
                    cat_estatus_usuarios.Estatus,
                    cat_estatus_usuarios.Descripcion,
                    usuario.IdUsuario
                    FROM
                    usuario
                    INNER JOIN cat_estatus_usuarios ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
                    INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
                    LIMIT $limit
                    OFFSET $offset";

  $consultaLikeSearch = "SELECT
                    usuario.Nombre,
                    cat_tipousuario.TipoUsuario,
                    cat_estatus_usuarios.Estatus,
                    cat_estatus_usuarios.Descripcion,
                    usuario.IdUsuario
                    FROM
                    usuario
                    INNER JOIN cat_estatus_usuarios ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
                    INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
                        WHERE Nombre LIKE '%$likeSearch%'
                        LIMIT $limit
                        OFFSET $offset";

$totalConsultaTodos = "SELECT
                    COUNT(usuario.IdUsuario) as Total
                    FROM
                    usuario";
                    
$totalConsultaLikeSearch = "SELECT
                    COUNT(usuario.IdUsuario) as Total
                    FROM
                    usuario 
                    WHERE Nombre LIKE '%$likeSearch%'";  

  try {
      if($columnaGenerica != null){
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consultaGenerica);
          $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($totalConsultaGenerica);
          $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $mTotal = json_decode( json_encode($total[0]) , true );
          
          $mCustomResponse = new CustomResponse(200,  $usuarios, null, (int)$pageForReturn, (int)$mTotal['Total'] );
          
          return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else if($likeSearch != null){
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consultaLikeSearch);
      $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($totalConsultaLikeSearch);
      $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $mTotal = json_decode( json_encode($total[0]) , true );
      
      $mCustomResponse = new CustomResponse(200,  $usuarios, null, (int)$pageForReturn, (int)$mTotal['Total']);

      return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
                
    } else if ($likeSearch == null) {
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaTodos);
        $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaTodos);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $mTotal = json_decode( json_encode($total[0]) , true );

        $mCustomResponse = new CustomResponse(200,  $usuarios, null, (int)$pageForReturn, (int)$mTotal['Total']);
        
        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else {
      $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
      return $mCustomHelper -> returnCatchAsJson($mErrorResponse );

    }

  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }

});










/*
//obetener usuarios
$app -> get('/api/usuario/', function(Request $request, Response $response){
  
  $limit = $request -> getParam('limit');
  $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $count = "SELECT COUNT(*) as Total FROM usuario";

  $consulta = "select usuario.IdUsuario, usuario.Nombre, usuario.Contrasena, cat_tipousuario.TipoUsuario
from usuario
INNER JOIN cat_tipousuario on usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      if($usuarios) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($usuarios, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});
*/

//obetener usuario en especifico
$app -> get('/api/usuario/nombre/', function(Request $request, Response $response){

$nombre = $request -> getParam('Nombre');

  $consulta = "select usuario.Nombre, usuario.Contrasena, cat_tipousuario.TipoUsuario
from usuario
INNER JOIN cat_tipousuario on usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
WHERE Nombre LIKE '%$nombre%'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      if($usuarios) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($usuarios, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//agregar usuarios
$app -> post('/api/usuario/agregar', function(Request $request, Response $response){

$nombre = $request -> getParam('Nombre');
$contrasena = $request -> getParam('Contrasena');
$tipoU = $request -> getParam('FkCat_TipoUsuario');


  $consulta = "INSERT INTO usuario(Nombre, Contrasena, FkCat_TipoUsuario)
  values (:Nombre, :Contrasena, :FkCat_TipoUsuario)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':Contrasena', $contrasena);
      $stmt -> bindParam(':FkCat_TipoUsuario', $tipoU);
      $stmt -> execute();
      echo '{"notice": {"text": "Usuario agregado"}';
      //Exportar y mostrar JSON
      if($stmt) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Acrualizar usuarios
$app -> put('/api/usuario/actualizar/{IdUsuario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdUsuario');
  $nombre = $request -> getParam('Nombre');
  $contrasena = $request -> getParam('Contrasena');
  $tipoU = $request -> getParam('FkCat_TipoUsuario');



  $consulta = "UPDATE  usuario SET
      Nombre =                       :Nombre,
      Contrasena =               :Contrasena,
      FkCat_TipoUsuario =  :FkCat_TipoUsuario

  WHERE IdUsuario = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':Contrasena', $contrasena);
      $stmt -> bindParam(':FkCat_TipoUsuario', $tipoU);
      $stmt -> execute();
      echo '{"notice": {"text": "Usuario actualizado"}';
      //Exportar y mostrar JSON
      if($stmt) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($stmt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar usuarios
$app -> delete('/api/usuario/eliminar/{IdUsuario}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdUsuario');

  $consulta = "DELETE FROM usuario WHERE IdUsuario = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Usuario borrado"}';
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
