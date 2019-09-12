<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de utra ruta (para guiarse)

//obetener todos los ventas
$app -> get('/api/ventas', function(Request $request, Response $response){

  $consulta = "SELECT
  `cobrador`.`IdVenta`,
  `cobrador`.`NombreCobrador`,
  `cobrador`.`APaterno`,
  `cobrador`.`AMaterno`,
  `cobrador`.`Estatus`,
  `cobrador`.`FkRuta`
FROM
  `cobrador`";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($ventas);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//agregar ventas
$app -> post('/api/ventas/agregar', function(Request $request, Response $response){

$nombre = $request -> getParam('NombreCobrador');
$aPaterno = $request -> getParam('APaterno');
$aMaterno = $request -> getParam('AMaterno');
$estatus = $request -> getParam('Estatus');


$consulta = "INSERT INTO cobrador(NombreCobrador, APaterno, AMaterno, Estatus)
values (:NombreCobrador, :APaterno, :AMaterno, :Estatus)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':NombreCobrador', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "NombreCobrador agregado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Actualizar ventas
$app -> put('/api/ventas/actualizar/{IdVenta}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdVenta');
  $nombre = $request -> getParam('NombreCobrador');
  $aPaterno = $request -> getParam('APaterno');
  $aMaterno = $request -> getParam('AMaterno');
  $estatus = $request -> getParam('Estatus');



  $consulta = "UPDATE  cobrador SET
      NombreCobrador =       :NombreCobrador,
      APaterno =                   :APaterno,
      AMaterno =                   :AMaterno,
      Estatus =                      :Estatus

  WHERE IdVenta = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':NombreCobrador', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "Cobrador actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar ventas
$app -> delete('/api/ventas/eliminar/{IdVenta}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdVenta');

  $consulta = "DELETE FROM cobrador WHERE IdVenta = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Cobrador borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

?>
