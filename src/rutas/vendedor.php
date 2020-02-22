<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

// REVISAR FUNCIONAMIENTO DE RUTAS ACTUALIZADAS DE VENDEDOR.

//obetener todos los vendedores
$app -> get('/api/vendedores/', function(Request $request, Response $response){
    
    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;
    
  $count = "SELECT COUNT(*) as Total FROM usuario WHERE usuario.FkCat_TipoUsuario = 3";
  
  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario 
	ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
	INNER JOIN cat_estatus_usuarios 
  ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
  WHERE
  usuario.FkCat_TipoUsuario = 3
  LIMIT $limit
  OFFSET $offset";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $vendedores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db->conectar();
      $ejecutar1 = $db -> query($count);
      $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      if($vendedores) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($vendedores, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener un vendedor por id
$app -> get('/api/vendedores/IdUsuario/', function(Request $request, Response $response){

  $id = $request -> getParam('IdUsuario');
  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario 
	ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
	INNER JOIN cat_estatus_usuarios 
  ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
  WHERE
  cat_tipousuario.IdTipoUsuario = 3
  AND IdUsuario = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $vendedores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      //Exportar y mostrar JSON
      if($vendedores) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($vendedores, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
      

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obtener un vendedor por nombre
$app -> get('/api/vendedores/nombre/', function(Request $request, Response $response){

  $nombre = $request -> getParam('Nombre');

  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario 
	ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
	INNER JOIN cat_estatus_usuarios 
  ON usuario.FkCat_Estatus_Usuario = cat_estatus_usuarios.IdEstatus
  WHERE
  cat_tipousuario.IdTipoUsuario = 3 
  AND usuario.Nombre LIKE '%$nombre%'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $vendedores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      if($vendedores) {
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($vendedores, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//Actualizar vendedores
$app -> put('/api/vendedores/actualizar/{IdUsuario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdUsuario');
  $nombre = $request -> getParam('Nombre');
  $tipo = $request -> getParam('FkCat_TipoUsuario');
  $estatus = $request -> getParam('FkCat_Estatus_Usuario');

 $consulta = "UPDATE usuario 
  SET Nombre = :Nombre,
  AMateFkCat_TipoUsuario = :FkCat_TipoUsuario,
  FkCat_Estatus_Usuario = :FkCat_Estatus_Usuario
  WHERE IdUsuario = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':Nombre', $nombre);
      $stmt -> bindParam(':FkCat_TipoUsuario', $tipo);
      $stmt -> bindParam(':FkCat_Estatus_Usuario', $estatus);
      $stmt -> execute();
      
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

//Eliminar vendedores
$app -> delete('/api/vendedores/eliminar/{IdUsuario}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdUsuario');

  $consulta = "DELETE FROM usuario WHERE IdUsuario = '$id'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      //echo '{"notice": {"text": "Vendedor borrado"}';
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
