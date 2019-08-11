<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//obetener cliente
$app -> get('/api/cliente/{Nombre}', function(Request $request, Response $response){

$nombre = $request -> getAttribute('Nombre');

  $consulta = "select cliente.Nombre, cliente.APaterno, cliente.AMaterno, cliente.Telefono,
  cliente.Celular, cliente.Sexo, cliente.CasaPropia, cliente.AutoPropio, cliente.LugarTrabajo,
  cliente.TelTrabajo, cliente.Antiguedad, cat_estado.NomEstado, cat_municipio.NomMunicipio,
  cat_colonia.NomColonia, cat_colonia.CP, cat_calle.NomCalle, cat_calle.Tipo, direccion.NumExterior,
  direccion.NumInterior, cliente.Estatus
from cliente
inner join direccion on cliente.FkDireccion = direccion.IdDireccion
inner join cat_estado on direccion.FkEstado = cat_estado.IdEstado
inner join cat_municipio on direccion.FkMunicipio = cat_municipio.IdMunicipio
inner join cat_colonia on direccion.FkColonia = cat_colonia.IdColonia
inner join cat_calle on direccion.FkCalle = cat_calle.IdCalle
WHERE Nombre = '$nombre';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $clientes = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($clientes);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//agregar cliente
$app -> post('/api/cliente/agregar', function(Request $request, Response $response){

$nombre = $request -> getParam('Nombre');
$APaterno = $request -> getParam('APaterno');
$AMaterno = $request -> getParam('AMaterno');
$tel;
$cel;
$sexo;
$casa;
$auto;
$lugarTrabajo;
$telTrabajo;
$antiguedad;

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
