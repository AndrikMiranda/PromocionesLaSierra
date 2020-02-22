<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//$app = new \Slim\App;

//INCOMPLETO. Estructura de otra ruta (para guiarse).

$fkVendedorParaSubVenta;

//obetener todas las notificaciones PAGINATION TEST
$app -> get('/api/notificacionesprueba/', function(Request $request, Response $response){


    $limit = $request -> getParam('limit');
    $page = $request -> getParam('page');
    
    $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
    $limit = isset( $limit ) ? $limit : 10;
    $offset = (--$pageReal) * $limit;
    
  $count = "SELECT COUNT(*) as Total FROM `tabla_valor`";
  $consulta = "SELECT
  idTablaValor,
  clave,
  dato12,
  descripcion13,
  dato13,
  descripcion14,
  dato14,
  descripcion15,
  dato15,
  descripcion16,
  dato16,
  descripcion17,
  dato17,
  descripcion18,
  dato18
FROM
  tabla_valor
  LIMIT $limit
  OFFSET $offset";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db->conectar();
      $ejecutar = $db -> query($consulta);
      $stmt = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      echo json_encode($stmt);
      
      
      $db = new db();
      $db = $db->conectar();
      $ejecutar1 = $db -> query($count);
      $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      //Exportar y mostrar JSON
      echo json_encode($stmt2);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener todas las notificaciones por clave
$app -> get('/api/notificaciones/claveprueba/', function(Request $request, Response $response){

  $clave = $request -> getParam('clave');
  $limit = $request -> getParam('limit');
  $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $count = "SELECT COUNT(*) as Total FROM tabla_valor WHERE clave = '$clave'";
  $consulta = "SELECT
  `tabla_valor`.`clave`,
  `tabla_valor`.`descripcion1`,
  `tabla_valor`.`dato1`,
  `tabla_valor`.`descripcion2`,
  `tabla_valor`.`dato2`,
  `tabla_valor`.`descripcion3`,
  `tabla_valor`.`dato3`,
  `tabla_valor`.`descripcion4`,
  `tabla_valor`.`dato4`,
  `tabla_valor`.`descripcion5`,
  `tabla_valor`.`dato5`,
  `tabla_valor`.`descripcion6`,
  `tabla_valor`.`dato6`,
  `tabla_valor`.`descripcion7`,
  `tabla_valor`.`dato7`,
  `tabla_valor`.`descripcion8`,
  `tabla_valor`.`dato8`,
  `tabla_valor`.`descripcion9`,
  `tabla_valor`.`dato9`,
  `tabla_valor`.`descripcion10`,
  `tabla_valor`.`dato10`,
  `tabla_valor`.`descripcion11`,
  `tabla_valor`.`dato11`,
  `tabla_valor`.`descripcion12`,
  `tabla_valor`.`dato12`,
  `tabla_valor`.`descripcion13`,
  `tabla_valor`.`dato13`,
  `tabla_valor`.`descripcion14`,
  `tabla_valor`.`dato14`,
  `tabla_valor`.`descripcion15`,
  `tabla_valor`.`dato15`,
  `tabla_valor`.`descripcion16`,
  `tabla_valor`.`dato16`,
  `tabla_valor`.`descripcion17`,
  `tabla_valor`.`dato17`,
  `tabla_valor`.`descripcion18`,
  `tabla_valor`.`dato18`
FROM
  `tabla_valor`
  WHERE `tabla_valor`.`clave` = '$clave'";
//echo $clave;
  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;
      
      $db = new db();
      $db = $db->conectar();
      $ejecutar1 = $db -> query($count);
      $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
       $json = json_encode($notificaciones);
      return $json;

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener notificaciones de venta por estatus
$app -> get('/api/notificaciones/ventas/Estatusprueba/', function(Request $request, Response $response){

  $estatus = $request -> getParam('estatus');
  $limit = $request -> getParam('limit');
  $page = $request -> getParam('page');
  
  $pageReal = (isset( $page ) && $page > 0) ? $page : 1;
  $limit = isset( $limit ) ? $limit : 10;
  $offset = (--$pageReal) * $limit;
  
  $count = "SELECT COUNT(*) as Total FROM tabla_valor WHERE tabla_valor.dato14 = '$estatus'";

  $consulta = "SELECT
    tabla_valor.idTablaValor,
    tabla_valor.clave,
    tabla_valor.descripcion1,
    tabla_valor.dato1,
    tabla_valor.descripcion2,
    tabla_valor.dato2,
    tabla_valor.descripcion3,
    tabla_valor.dato3,
    tabla_valor.descripcion4,
    tabla_valor.dato4,
    tabla_valor.descripcion5,
    tabla_valor.dato5,
    tabla_valor.descripcion6,
    tabla_valor.dato6,
    tabla_valor.descripcion7,
    tabla_valor.dato7,
    tabla_valor.descripcion8,
    tabla_valor.dato8,
    tabla_valor.descripcion9,
    tabla_valor.dato9,
    tabla_valor.descripcion10,
    tabla_valor.dato10,
    tabla_valor.descripcion11,
    tabla_valor.dato11,
    tabla_valor.descripcion12,
    tabla_valor.dato12,
    tabla_valor.descripcion13,
    tabla_valor.dato13,
    tabla_valor.descripcion14,
    tabla_valor.dato14
  FROM
    tabla_valor
  WHERE
    tabla_valor.dato14 = '$estatus'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      $db = new db();
      $db = $db->conectar();
      $ejecutar1 = $db -> query($count);
      $stmt2 = $ejecutar1 -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
       $json = json_encode($notificaciones);
      return $json;

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//obetener notificaciones de venta por estatus
$app -> get('/api/notificaciones/ventas/EstatusIdPrueba/', function(Request $request, Response $response){

      $idTablaValor = $request -> getParam('idTablaValor');

  $consulta = "SELECT
    tabla_valor.idTablaValor,
    tabla_valor.clave,
    tabla_valor.descripcion1,
    tabla_valor.dato1,
    tabla_valor.descripcion2,
    tabla_valor.dato2,
    tabla_valor.descripcion3,
    tabla_valor.dato3,
    tabla_valor.descripcion4,
    tabla_valor.dato4,
    tabla_valor.descripcion5,
    tabla_valor.dato5,
    tabla_valor.descripcion6,
    tabla_valor.dato6,
    tabla_valor.descripcion7,
    tabla_valor.dato7,
    tabla_valor.descripcion8,
    tabla_valor.dato8,
    tabla_valor.descripcion9,
    tabla_valor.dato9,
    tabla_valor.descripcion10,
    tabla_valor.dato10,
    tabla_valor.descripcion11,
    tabla_valor.dato11,
    tabla_valor.descripcion12,
    tabla_valor.dato12,
    tabla_valor.descripcion13,
    tabla_valor.dato13,
    tabla_valor.descripcion14,
    tabla_valor.dato14
  FROM
    tabla_valor
  WHERE
    tabla_valor.idTablaValor = $idTablaValor and tabla_valor.clave = 'NOTI-VENTA'";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $notificaciones = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($notificaciones);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

?>
