<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//INCOMPLETO. Estructura de otra ruta (para guiarse).

$app -> get('/api/cobranza/', function(Request $request, Response $response){
  $mCustomHelper = new MyCustomHelper();

  $idUsuario = $request->getParam('idUser');
  $page = $request->getParam('page');
  $limit = $request->getParam('pageSize');
  $likeSearch = $request->getParam('likeSearch');
  $columnaGenerica = $request->getParam('columnaGenerica');
  $parametroColumnaGenerica = $request->getParam('parametroGenerico');

  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $pageForReturn = $pageReal;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $consultaGenerica = "SELECT
cobranza.IdCobranza,
cobranza.FechaCobro,
cobranza.Abono,
cobranza.MontoVencido,
cobranza.AbonoVencido,
cobranza.AbonoAtrasado,
cobranza.PrimerCobro,
cobranza.Comentario,
cobranza.GpsLat,
cobranza.GpsLon,
usuario.Nombre
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $totalConsultaGenerica = "SELECT
cobranza.IdCobranza,
cobranza.FechaCobro,
cobranza.Abono,
cobranza.MontoVencido,
cobranza.AbonoVencido,
cobranza.AbonoAtrasado,
cobranza.PrimerCobro,
cobranza.Comentario,
cobranza.GpsLat,
cobranza.GpsLon,
usuario.Nombre
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio
                    WHERE ".$columnaGenerica." = '$parametroColumnaGenerica' 
                    LIMIT $limit
                    OFFSET $offset";
  
  $consultaTodos = "SELECT
cobranza.IdCobranza,
cobranza.FechaCobro,
cobranza.Abono,
cobranza.MontoVencido,
cobranza.AbonoVencido,
cobranza.AbonoAtrasado,
cobranza.PrimerCobro,
cobranza.Comentario,
cobranza.GpsLat,
cobranza.GpsLon,
usuario.Nombre
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio
                    LIMIT $limit
                    OFFSET $offset";

  $consultaLikeSearch = "SELECT
cobranza.IdCobranza,
cobranza.FechaCobro,
cobranza.Abono,
cobranza.MontoVencido,
cobranza.AbonoVencido,
cobranza.AbonoAtrasado,
cobranza.PrimerCobro,
cobranza.Comentario,
cobranza.GpsLat,
cobranza.GpsLon,
usuario.Nombre
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio
                       WHERE cobranza.FechaCobro LIKE '%$likeSearch%' OR
                    cobranza.AbonoVencido LIKE '%$likeSearch%' OR
                    cobranza.AbonoAtrasado LIKE '%$likeSearch%' OR
                    cobranza.Comentario LIKE '%$likeSearch%' OR
                    cobranza.GpsLat LIKE '%$likeSearch%' OR
                    cobranza.GpsLon LIKE '%$likeSearch%' OR
                    usuario.Nombre LIKE '%$likeSearch%'
                        LIMIT $limit
                        OFFSET $offset";

$totalConsultaTodos = "SELECT
                    COUNT(cobranza.IdCobranza) as Total
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio";
                    
$totalConsultaLikeSearch = "SELECT
cobranza.IdCobranza,
cobranza.FechaCobro,
cobranza.Abono,
cobranza.MontoVencido,
cobranza.AbonoVencido,
cobranza.AbonoAtrasado,
cobranza.PrimerCobro,
cobranza.Comentario,
cobranza.GpsLat,
cobranza.GpsLon,
usuario.Nombre
FROM
cobranza
INNER JOIN usuario ON cobranza.FkCobrador = usuario.IdUsuario
INNER JOIN cat_lio ON cobranza.FkLio = cat_lio.IdLio

                    WHERE cobranza.FechaCobro LIKE '%$likeSearch%' OR
                    cobranza.AbonoVencido LIKE '%$likeSearch%' OR
                    cobranza.AbonoAtrasado LIKE '%$likeSearch%' OR
                    cobranza.Comentario LIKE '%$likeSearch%' OR
                    cobranza.GpsLat LIKE '%$likeSearch%' OR
                    cobranza.GpsLon LIKE '%$likeSearch%' OR
                    usuario.Nombre LIKE '%$likeSearch%'";  

  try {
      if($columnaGenerica != null){
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($consultaGenerica);
          $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $db = new db();
          $db = $db -> conectar();
          $ejecutar = $db -> query($totalConsultaGenerica);
          $mTotal = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
          $db = null;
          
          $mTotal = json_decode( json_encode($total[0]) , true );
          
          $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total'] );
          
          return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else if($likeSearch != null){
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consultaLikeSearch);
      $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($totalConsultaLikeSearch);
      $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $mTotal = json_decode( json_encode($total[0]) , true );
      
      $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total']);

      return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
                
    } else if ($likeSearch == null) {
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($consultaTodos);
        $ventas = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $db = new db();
        $db = $db -> conectar();
        $ejecutar = $db -> query($totalConsultaTodos);
        $total = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $mTotal = json_decode( json_encode($total[0]) , true );

        $mCustomResponse = new CustomResponse(200,  $ventas, null, (int)$pageForReturn, (int)$mTotal['Total']);
        
        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write( $mCustomHelper -> returnCatchAsJson($mCustomResponse ) );
        
    } else {
      $mErrorResponse = new ErrorResponse(200, 'Hubo un problema con la solicitud. Intentelo de nuevo.', false);
      return $mCustomHelper -> returnCatchAsJson($mErrorResponse );

    }

  } catch (PDOException $e) {
    $mErrorResponse = new ErrorResponse(500, $e -> getMessage(), true);
    return $mCustomHelper -> returnCatchAsJson($mErrorResponse );
  }
});

/*
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
*/

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
