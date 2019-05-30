<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//obetener usuarios
$app -> get('/api/usuario', function(Request $request, Response $response){

  $consulta = "select usuario.Nombre, usuario.Contrasena, cat_tipousuario.TipoUsuario
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
      echo json_encode($usuarios);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//obetener usuario en especifico
$app -> get('/api/usuario/{Nombre}', function(Request $request, Response $response){

$nombre = $request -> getAttribute('Nombre');

  $consulta = "select usuario.Nombre, usuario.Contrasena, cat_tipousuario.TipoUsuario
from usuario
INNER JOIN cat_tipousuario on usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
WHERE Nombre LIKE '%$nombre%';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $usuarios = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($usuarios);

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
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


?>
