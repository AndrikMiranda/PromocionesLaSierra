<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

// REVISAR FUNCIONAMIENTO DE RUTAS ACTUALIZADAS DE VENDEDOR.

//obetener todos los vendedores
$app -> get('/api/vendedores', function(Request $request, Response $response){

  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
  WHERE
  cat_tipousuario.IdTipoUsuario = 3";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $vendedores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($vendedores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});
/*
//obetener un vendedor por id
$app -> get('/api/vendedores/{IdUsuario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdUsuario');
  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
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
      echo json_encode($vendedores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obtener un vendedor por nombre
$app -> get('/api/vendedores/nombre/{Nombre}', function(Request $request, Response $response){

  $nombre = $request -> getAttribute('Nombre');

  $consulta = "SELECT
  usuario.Nombre,
  usuario.IdUsuario,
  cat_tipousuario.TipoUsuario,
  cat_estatus_usuarios.Estatus,
  cat_estatus_usuarios.Descripcion
  FROM
  usuario
  INNER JOIN cat_tipousuario ON usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario ,
  cat_estatus_usuarios
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
      echo json_encode($vendedores);

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
      echo '{"notice": {"text": "Vendedor actualizado"}';
      //Exportar y mostrar JSON

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
      echo '{"notice": {"text": "Vendedor borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});
*/
?>
