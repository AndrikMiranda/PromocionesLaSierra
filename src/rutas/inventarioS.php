<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//--------------------------------OBETENER INVENTARIO COMPLETO
$app -> get('/api/inventarioS', function(Request $request, Response $response){

  $consulta = "select inventariosecundario.IdInventarioS, articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  inventariosecundario.IdInventarioS, inventariosecundario.CantidadSecundario
from inventariosecundario
INNER JOIN inventarioprincipal on inventarioprincipal.IdInventarioP = inventariosecundario.FkInventarioP
INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});

//--------------------------------OBTENER INVENTARIO POR LA CATEGORIA DE ARTICULO
$app -> get('/api/inventarioS/categoria/{NombreCategoria}', function(Request $request, Response $response){

  $categoria = $request -> getAttribute('NombreCategoria');

  $consulta = "select inventariosecundario.IdInventarioS, articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  inventariosecundario.IdInventarioS, inventariosecundario.CantidadSecundario
from inventariosecundario
INNER JOIN inventarioprincipal on inventarioprincipal.IdInventarioP = inventariosecundario.FkInventarioP
INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
WHERE cat_categoriaarticulos.NombreCategoria LIKE '%$categoria%';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


//--------------------------------OBTENER INVENTARIO POR NOMBRE DEL ARTICULO
$app -> get('/api/inventarioS/articulo/{NombreArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('NombreArticulo');

  $consulta = "select inventariosecundario.IdInventarioS, articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  inventariosecundario.IdInventarioS, inventariosecundario.CantidadSecundario
  from inventariosecundario
  INNER JOIN inventarioprincipal on inventarioprincipal.IdInventarioP = inventariosecundario.FkInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  WHERE cat_categoriaarticulos.NombreCategoria LIKE '%$articulo%';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//--------------------------------OBTENER INVENTARIO POR CODIGO
$app -> get('/api/inventarioS/codigo/{Codigo}', function(Request $request, Response $response){

  $codigo = $request -> getAttribute('Codigo');

  $consulta = "select inventariosecundario.IdInventarioS, articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  inventariosecundario.IdInventarioS, inventariosecundario.CantidadSecundario
  from inventariosecundario
  INNER JOIN inventarioprincipal on inventarioprincipal.IdInventarioP = inventariosecundario.FkInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
WHERE cat_categoriaarticulos.NombreCategoria LIKE '%$codigo%';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//--------------------------------AGREGAR PRODUCTO NUEVO A INVENTARIO SECUNDARIO
$app -> post('/api/inventarioS/agregarnuevo', function(Request $request, Response $response){

$FkInventario = $request -> getParam('FkInventarioP');
$cantidad = $request -> getParam('CantidadSecundario');
$tipoMovimiento = $request -> getParam('FkTipoMovimiento');

//  --------------- Verificar que no se encuentre ya registrado
$consulta1 = "SELECT FkInventarioP FROM inventariosecundario
WHERE FkInventarioP = $FkInventario";

try {

  //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $ejecutar = $db -> query($consulta1);
    $inventarioExiste = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $json = json_encode($inventarioExiste);
    echo $json;

} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}

$decode=json_decode($json, true);
$id = $decode[0]['FkInventarioP'];

if ($id > 0) {
  echo '{"error": {"text": "El producto que desea ingresar ya se encuentra registrado en el inventario"}';
  $FkInventario = null;
  $cantidad = null;
  $tipoMovimiento = null;
}

// Insert en el inventario secundario

  $consulta2 = "INSERT INTO inventariosecundario(FkInventarioP, CantidadSecundario)
  values (:FkInventarioP, :CantidadSecundario)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta2);
      $stmt -> bindParam(':FkInventarioP', $FkInventario);
      $stmt -> bindParam(':CantidadSecundario', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  // Obtener el id del ultimo insert realizado
  $consulta3 = ("SELECT IdInventarioS FROM inventariosecundario ORDER BY 'IdInventarioS' DESC LIMIT 1");

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta3);
      $idInv = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      $json = json_encode($idInv);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $decode=json_decode($json, true);
  $idInv = $decode[0]['IdInventarioS'];

  echo $idInv;

  // Insert en movimientoinventario

  $consulta4 = ("INSERT INTO movimientoinventario(FkInventarioS, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioS, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  //AQUI ES EL PROBLEMA CON EL ID
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta4);
    $stmt -> bindParam(':FkInventarioS', $idInv);
    $stmt -> bindParam(':Cantidad', $cantidad);
    $stmt -> bindParam(':Fecha', $fecha);
    $stmt -> bindParam(':FkUsuario', $usuario);
    $stmt -> bindParam(':FkTipoMovimiento', $tipoMovimiento);
    $stmt -> execute();
      echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//--------------------------------EDITAR CANTIDAD DE PRODUCTO POR ID
$app -> put('/api/inventarioS/actualizarcantidad/{IdInventarioS}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdInventarioS');
  $cantidad = $request -> getParam('CantidadSecundario');
  $tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = "UPDATE inventariosecundario SET CantidadSecundario =
  :CantidadSecundario WHERE IdInventarioS = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta1);
      $stmt -> bindParam(':CantidadSecundario', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta2 = ("INSERT INTO movimientoinventario(FkInventarioS, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioS, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  $inventario = $id;
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkInventarioS', $inventario);
    $stmt -> bindParam(':Cantidad', $cantidad);
    $stmt -> bindParam(':Fecha', $fecha);
    $stmt -> bindParam(':FkUsuario', $usuario);
    $stmt -> bindParam(':FkTipoMovimiento', $tipoMovimiento);
    $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//-------------------------------EDITAR LA CANTIDAD DE PRODUCTOS POR ARTICULO
$app -> put('/api/inventarioS/actualizarcantidadart/{FkArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('FkArticulo');
  $cantidad = $request -> getParam('CantidadSecundario');
  $tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = ("SELECT IdInventarioS FROM inventariosecundario
    INNER JOIN inventarioprincipal on inventariosecundario.FkInventarioP = inventarioprincipal.IdInventarioP
    WHERE FkArticulo = $articulo LIMIT 1");

  try {
    $db = new db();
    $db = $db -> conectar();
    $ejecutar = $db -> query($consulta1);
    $id = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $json = json_encode($id);
    echo $json;


  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $decode=json_decode($json, true);
  $id = $decode[0]['IdInventarioS'];
  echo $id;


  $consulta2 = "UPDATE  inventariosecundario SET CantidadSecundario =
  :CantidadSecundario WHERE IdInventarioS = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta2);
      $stmt -> bindParam(':CantidadSecundario', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta3 = ("INSERT INTO movimientoinventario(FkInventarioS, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioP, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  //AQUI ES EL PROBLEMA CON EL ID
  $Finventario = $id;
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta3);
    $stmt -> bindParam(':FkInventarioP', $id);
    $stmt -> bindParam(':Cantidad', $cantidad);
    $stmt -> bindParam(':Fecha', $fecha);
    $stmt -> bindParam(':FkUsuario', $usuario);
    $stmt -> bindParam(':FkTipoMovimiento', $tipoMovimiento);
    $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//--------------------------------ELIMINAR PRODUCTO DE INVENTARIO
$app -> delete('/api/inventarioS/eliminar/{IdInventarioS}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdInventarioS');
$tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = "DELETE FROM inventariosecundario WHERE IdInventarioS = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta1);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Registro de inventario borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta2 = ("INSERT INTO movimientoinventario(FkInventarioS, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioS, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  $inventario = $id;
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkInventarioS', $inventario);
    $stmt -> bindParam(':Cantidad', $cantidad);
    $stmt -> bindParam(':Fecha', $fecha);
    $stmt -> bindParam(':FkUsuario', $usuario);
    $stmt -> bindParam(':FkTipoMovimiento', $tipoMovimiento);
    $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


?>
