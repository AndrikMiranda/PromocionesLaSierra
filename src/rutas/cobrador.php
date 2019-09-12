<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//obetener todos los cobradores
$app -> get('/api/cobradores', function(Request $request, Response $response){

  $consulta = "SELECT
  `cobrador`.`IdCobrador`,
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
      $cobradores = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cobradores);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//agregar cobradores
$app -> post('/api/cobradores/agregar', function(Request $request, Response $response){

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


//Actualizar cobradores
$app -> put('/api/cobradores/actualizar/{IdCobrador}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdCobrador');
  $nombre = $request -> getParam('NombreCobrador');
  $aPaterno = $request -> getParam('APaterno');
  $aMaterno = $request -> getParam('AMaterno');
  $estatus = $request -> getParam('Estatus');



  $consulta = "UPDATE  cobrador SET
      NombreCobrador =       :NombreCobrador,
      APaterno =                   :APaterno,
      AMaterno =                   :AMaterno,
      Estatus =                      :Estatus

  WHERE IdCobrador = $id";

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

//Eliminar cobradores
$app -> delete('/api/cobradores/eliminar/{IdCobrador}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCobrador');

  $consulta = "DELETE FROM cobrador WHERE IdCobrador = '$id';";

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
