<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de otra ruta (para guiarse).

//obetener todas las cuentas
$app -> get('/api/cuentas', function(Request $request, Response $response){

  $consulta = "SELECT
    `cuenta`.`IdCuenta`,
    `cuenta`.`NumeroCuenta`,
    `cuenta`.`FkCliente`,
    `cuenta`.`SaldoTotal`,
    `cuenta`.`EstatusPagador`,
    `cuenta`.`ContadorVencidos`,
    `cuenta`.`ContadorAtrasados`,
    `cliente`.`Nombre`,
    `cliente`.`APaterno`,
    `cliente`.`AMaterno`
  FROM
    `cuenta`
  INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cuentas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cuentas);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener cuenta por id
$app -> get('/api/cuentas/{IdCuenta}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCuenta');

$consulta = "  SELECT
  `cuenta`.`IdCuenta`,
  `cuenta`.`NumeroCuenta`,
  `cuenta`.`FkCliente`,
  `cuenta`.`SaldoTotal`,
  `cuenta`.`EstatusPagador`,
  `cuenta`.`ContadorVencidos`,
  `cuenta`.`ContadorAtrasados`,
  `cliente`.`Nombre`,
  `cliente`.`APaterno`,
  `cliente`.`AMaterno`
FROM
  `cuenta`
INNER JOIN `cliente` ON `cuenta`.`FkCliente` = `cliente`.`IdCliente`
WHERE `cuenta`.`IdCuenta` = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $cuentas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($cuentas);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//agregar cuenta
$app -> post('/api/cuentas/agregar', function(Request $request, Response $response){

$numeroCuenta = $request -> getParam('NumeroCuenta');
$fkCliente = $request -> getParam('FkCliente');
$total = $request -> getParam('SaldoTotal');
$estatus = $request -> getParam('EstatusPagador');
$contV = $request -> getParam('ContadorVencidos');
$contA = $request -> getParam('ContadorAtrasados');

$consulta = "INSERT INTO cuenta(NumeroCuenta, FkCliente, SaldoTotal, EstatusPagador,
ContadorVencidos, ContadorAtrasados)
VALUES (:NumeroCuenta, :FkCliente, :SaldoTotal, :EstatusPagador,
:ContadorVencidos, :ContadorAtrasados)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':NumeroCuenta', $numeroCuenta);
      $stmt -> bindParam(':FkCliente', $fkCliente);
      $stmt -> bindParam(':SaldoTotal', $total);
      $stmt -> bindParam(':EstatusPagador', $estatus);
      $stmt -> bindParam(':ContadorVencidos', $contV);
      $stmt -> bindParam(':ContadorAtrasados', $contA);
      $stmt -> execute();
      echo '{"notice": {"text": "Cuenta agregado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Actualizar cuenta
$app -> put('/api/cuentas/actualizar/{IdCuenta}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdCuenta');

  $numeroCuenta = $request -> getParam('NumeroCuenta');
  $fkCliente = $request -> getParam('FkCliente');
  $total = $request -> getParam('SaldoTotal');
  $estatus = $request -> getParam('EstatusPagador');
  $contV = $request -> getParam('ContadorVencidos');
  $contA = $request -> getParam('ContadorAtrasados');
  $nombre = $request -> getParam('Nombre');
  $aPaterno = $request -> getParam('APaterno');
  $aMaterno = $request -> getParam('AMaterno');



  $consulta = "UPDATE  Cuenta SET
      NumeroCuenta =           :NumeroCuenta,
      FkCliente =                 :FkCliente,
      SaldoTotal =               :SaldoTotal,
      EstatusPagador =       :EstatusPagador,
      ContadorVencidos =   :ContadorVencidos,
      ContadorAtrasados = :ContadorAtrasados,
      Nombre =                       :Nombre,
      APaterno =                   :APaterno,
      AMaterno =                   :AMaterno

  WHERE IdCuenta = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $numeroCuenta = $request -> getParam('NumeroCuenta');
      $fkCliente = $request -> getParam('FkCliente');
      $total = $request -> getParam('SaldoTotal');
      $estatus = $request -> getParam('EstatusPagador');
      $contV = $request -> getParam('ContadorVencidos');
      $contA = $request -> getParam('ContadorAtrasados');
      $nombre = $request -> getParam('Nombre');
      $aPaterno = $request -> getParam('APaterno');
      $aMaterno = $request -> getParam('AMaterno');
      $stmt -> execute();
      echo '{"notice": {"text": "Cuenta actualizada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar cliente
$app -> delete('/api/cuentas/eliminar/{IdCuenta}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdCuenta');

  $consulta = "DELETE FROM Cuenta WHERE IdCuenta = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Cuenta borrada"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

?>
