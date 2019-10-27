<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//INCOMPLETO. Estructura de otra ruta (para guiarse).

//obetener todos las cobranzas
$app -> get('/api/cobranza/todos', function(Request $request, Response $response){

  $consulta = "SELECT
                    cobranza.IdCobranza,
                    cobranza.FkCobrador,
                    cobranza.FkVenta,
                    cobranza.FechaCobro,
                    cobranza.Abono,
                    cobranza.MontoVencido,
                    cobranza.AbonoVencido,
                    cobranza.AbonoAtrasado,
                    cobranza.PrimerCobro,
                    cobranza.FkLio,
                    cobranza.Comentario,
                    cobranza.GpsLat,
                    cobranza.GpsLon
                FROM
                    cobranza";

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

//obetener todos las cobranzas por ID
$app -> get('/api/cobranza/{IdCobranza}', function(Request $request, Response $response){

    $idCobranza = $request -> getParam('IdCobranza');

    $consulta = "SELECT
                      cobranza.IdCobranza,
                      cobranza.FkCobrador,
                      cobranza.FkVenta,
                      cobranza.FechaCobro,
                      cobranza.Abono,
                      cobranza.MontoVencido,
                      cobranza.AbonoVencido,
                      cobranza.AbonoAtrasado,
                      cobranza.PrimerCobro,
                      cobranza.FkLio,
                      cobranza.Comentario,
                      cobranza.GpsLat,
                      cobranza.GpsLon
                  FROM
                      cobranza
                  WHERE 
                      IdCobranza = $idCobranza";
  
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
$app -> post('/api/cobranza/cobrar', function(Request $request, Response $response){

$fkCobrador = $request -> getParam('FkCobrador');
$fkVenta = $request -> getParam('FkVenta');
$abono = $request -> getParam('Abono');
$montoVencido = $request -> getParam('MontoVencido');
$abonoVencido = $request -> getParam('AbonoVencido');
$abonoAtrasado = $request -> getParam('AbonoAtrasado');
$primerCobro = $request -> getParam('PrimerCobro');
$fkLio = $request -> getParam('FkLio');
$comentario = $request -> getParam('Comentario');
$gpsLat = $request -> getParam('GpsLat');
$gpsLon = $request -> getParam('GpsLon');

$consulta = "INSERT INTO cobranza(FkCobrador, FkVenta, FechaCobro,
                                  Abono, MontoVencido, AbonoVencido,
                                  AbonoAtrasado, PrimerCobro, FkLio,
                                  Comentario, GpsLat, GpsLon)
                          values (:fkCobrador, :fkVenta, CURDATE(), 
                                  :abono, :montoVencido, :abonoVencido,
                                  :abonoAtrasado, :primerCobro, :fkLio,
                                  :comentario, :gpsLat, :gpsLon )";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      
      $stmt -> bindParam(':fkCobrador', $fkCobrador);
      $stmt -> bindParam(':fkVenta', $fkVenta);
      $stmt -> bindParam(':abono', $abono);
      $stmt -> bindParam(':montoVencido', $montoVencido);
      $stmt -> bindParam(':abonoVencido', $abonoVencido);
      $stmt -> bindParam(':abonoAtrasado', $abonoAtrasado);
      $stmt -> bindParam(':primerCobro', $primerCobro);
      $stmt -> bindParam(':fkLio', $fkLio);
      $stmt -> bindParam(':comentario', $comentario);
      $stmt -> bindParam(':gpsLat', $gpsLat);
      $stmt -> bindParam(':gpsLon', $gpsLon);

      $stmt -> execute();
      echo '{"notice": {"text": "Cobranza realizada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//Actualizar cobradores
$app -> put('/api/cobranza/actualizar/{IdCobranza}', function(Request $request, Response $response){

    $idCobranza = $request -> getAttribute('IdCobranza');
    $fkCobrador = $request -> getParam('FkCobrador');
    $fkVenta = $request -> getParam('FkVenta');
    $abono = $request -> getParam('Abono');
    $montoVencido = $request -> getParam('MontoVencido');
    $abonoVencido = $request -> getParam('AbonoVencido');
    $abonoAtrasado = $request -> getParam('AbonoAtrasado');
    $primerCobro = $request -> getParam('PrimerCobro');
    $fkLio = $request -> getParam('FkLio');
    $comentario = $request -> getParam('Comentario');
    $gpsLat = $request -> getParam('GpsLat');
    $gpsLon = $request -> getParam('GpsLon');

  $consulta = "UPDATE  cobranza SET
      FkCobrador = :FkCobrador,
      FkVenta = :FkVenta,
      Abono = :Abono,
      MontoVencido = :MontoVencido,
      AbonoVencido = :AbonoVencido,
      AbonoAtrasado = :AbonoAtrasado,
      PrimerCobro = :PrimerCobro,
      FkLio = :FkLio,
      Comentario = :Comentario,
      GpsLat = :GpsLat,
      GpsLon = :GpsLon

  WHERE IdCobranza = $idCobranza";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);

      $stmt -> bindParam(':FkCobrador', $fkCobrador);
      $stmt -> bindParam(':FkVenta', $fkVenta);
      $stmt -> bindParam(':Abono', $abono);
      $stmt -> bindParam(':MontoVencido', $montoVencido);
      $stmt -> bindParam(':AbonoVencido', $abonoVencido);
      $stmt -> bindParam(':AbonoAtrasado', $abonoAtrasado);
      $stmt -> bindParam(':PrimerCobro', $primerCobro);
      $stmt -> bindParam(':FkLio', $fkLio);
      $stmt -> bindParam(':Comentario', $comentario);
      $stmt -> bindParam(':GpsLat', $gpsLat);
      $stmt -> bindParam(':GpsLon', $gpsLon);

      $stmt -> execute();
      echo '{"notice": {"text": "Cobranza  actualizada"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//Eliminar cobranza
$app -> delete('/api/cobranza/eliminar/{IdCobranza}', function(Request $request, Response $response){

    $idCobranza = $request -> getAttribute('IdCobranza');

  $consulta = "DELETE FROM cobranza WHERE IdCobranza = '$idCobranza';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Cobranza eliminada"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});



?>
