<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Registrar signup
$app -> post('/api/signup', function(Request $request, Response $response){

$nombre = $request -> getParam('Nombre');
$password = $request -> getParam('Contrasena');
$tipo = $request -> getParam('FkCat_TipoUsuario');
$estatus = $request -> getParam('FkCat_Estatus_Usuario');

$consulta = "INSERT INTO usuario (Nombre, Contrasena, FkCat_TipoUsuario, FkCat_Estatus_Usuario)
VALUES (:Nombre, :Contrasena, :FkCat_TipoUsuario, :FkCat_Estatus_Usuario)";

$contrasena = md5(base64_encode($password));

  try {

    //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta);
    $stmt -> bindParam(':Nombre', $nombre);
    $stmt -> bindParam(':Contrasena', $contrasena);
    $stmt -> bindParam(':FkCat_TipoUsuario', $tipo);
    $stmt -> bindParam(':FkCat_Estatus_Usuario', $estatus);
    $stmt -> execute();

      //Exportar y mostrar JSON
      echo '{"notice": {"text": "Usuario '.$contrasena.' agregado"}';

  } catch (PDOException $e) {
    echo '{"error": Usuario o Contraseña incorrectos '.$contrasena.' {"text": '.$e -> getMessage().'}';
  }

});


?>
