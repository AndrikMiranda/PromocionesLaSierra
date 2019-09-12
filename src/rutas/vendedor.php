<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//obetener todos los vendedores
$app -> get('/api/vendedores', function(Request $request, Response $response){

  $consulta = "SELECT
  `vendedor`.`IdVendedor`,
  `vendedor`.`NombreVendedor`,
  `vendedor`.`APaterno`,
  `vendedor`.`AMaterno`,
  `vendedor`.`Estatus`
FROM
  `vendedor`";

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

//obetener un vendedor por id
$app -> get('/api/vendedores/{IdVendedor}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdVendedor');
  $consulta = "SELECT
  `vendedor`.`IdVendedor`,
  `vendedor`.`NombreVendedor`,
  `vendedor`.`APaterno`,
  `vendedor`.`AMaterno`,
  `vendedor`.`Estatus`
FROM
  `vendedor` WHERE `IdVendedor` = $id";

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

//obetener un vendedor por nombre
$app -> get('/api/vendedores/{NombreVendedor}', function(Request $request, Response $response){

  $nombre = $request -> getAttribute('NombreVendedor');
  $consulta = "SELECT
  `vendedor`.`IdVendedor`,
  `vendedor`.`NombreVendedor`,
  `vendedor`.`APaterno`,
  `vendedor`.`AMaterno`,
  `vendedor`.`Estatus`
FROM
  `vendedor` WHERE `IdVendedor` = $nombre";

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

//agregar vendedores
$app -> post('/api/vendedores/agregar', function(Request $request, Response $response){

$nombre = $request -> getParam('NombreVendedor');
$aPaterno = $request -> getParam('APaterno');
$aMaterno = $request -> getParam('AMaterno');
$estatus = $request -> getParam('Estatus');


$consulta = "INSERT INTO vendedor(NombreVendedor, APaterno, AMaterno, Estatus)
values (:NombreVendedor, :APaterno, :AMaterno, :Estatus)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':NombreVendedor', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "Vendedor agregado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Actualizar vendedores
$app -> put('/api/vendedores/actualizar/{IdVendedor}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdVendedor');
  $nombre = $request -> getParam('NombreVendedor');
  $aPaterno = $request -> getParam('APaterno');
  $aMaterno = $request -> getParam('AMaterno');
  $estatus = $request -> getParam('Estatus');



  $consulta = "UPDATE  vendedor SET
      NombreVendedor =       :NombreVendedor,
      APaterno =                   :APaterno,
      AMaterno =                   :AMaterno,
      Estatus =                      :Estatus

  WHERE IdVendedor = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':NombreVendedor', $nombre);
      $stmt -> bindParam(':APaterno', $aPaterno);
      $stmt -> bindParam(':AMaterno', $aMaterno);
      $stmt -> bindParam(':Estatus', $estatus);
      $stmt -> execute();
      echo '{"notice": {"text": "Vendedor actualizado"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar vendedores
$app -> delete('/api/vendedores/eliminar/{IdVendedor}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdVendedor');

  $consulta = "DELETE FROM vendedor WHERE IdVendedor = '$id';";

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

?>
