<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//--------------------------------obetener inventario entero
$app -> get('/api/inventarioP', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal
from inventarioprincipal
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

//--------------------------------obetener inventario por categoria
$app -> get('/api/inventarioP/categoria/{NombreCategoria}', function(Request $request, Response $response){

  $categoria = $request -> getAttribute('NombreCategoria');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal
from inventarioprincipal
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

//--------------------------------obetener inventario por nombre de articulo
$app -> get('/api/inventarioP/articulo/{NombreArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('NombreArticulo');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal
from inventarioprincipal
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

//--------------------------------obetener inventario por codigo
$app -> get('/api/inventarioP/codigo/{Codigo}', function(Request $request, Response $response){

  $codigo = $request -> getAttribute('Codigo');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal
from inventarioprincipal
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

//--------------------------------agregar Productos nuevos
// BUSCAR MANERA PARA COMPROBAR QUE NO SE HAGA INSERT DE ALGUN PRODUCTO YA REGISRADO
$app -> post('/api/inventarioP/agregarnuevo', function(Request $request, Response $response){

$FkArticulo = $request -> getParam('FkArticulo');
$cantidad = $request -> getParam('CantidadPrincipal');

$consulta1 = "SELECT FkArticulo FROM inventarioprincipal WHERE FkArticulo = $FkArticulo";

try {

  //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $ejecutar = $db -> query($consulta1);
    $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
    $db = null;

    if ($FkArticulo >= $consulta1) {
      echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
      echo '{"notice": {"text": "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"}';
      $FkArticulo = null;
      $cantidad = null;
    }
    
} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}



$consulta = "INSERT INTO inventarioprincipal(FkArticulo, CantidadPrincipal)
values (:FkArticulo, :CantidadPrincipal)";
//IdMovimientoInventario	FkInventarioP	Cantidad	Fecha	FkUsuario	FkTipoMovimiento

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':FkArticulo', $FkArticulo);
      $stmt -> bindParam(':CantidadPrincipal', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta2 = ("INSERT INTO movimientoinventario(FkInventarioP, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioP, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  $Finventario = '1';
  $fecha = date("Y-m-d");
  $usuario = '2';
  $tipoMovimiento = '1';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkInventarioP', $Finventario);
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


//--------------------------------Editar la cantidad de productos por id
$app -> put('/api/inventarioP/actualizarcantidad/{IdInventarioP}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdInventarioP');
  $cantidad = $request -> getParam('CantidadPrincipal');

  $consulta = "UPDATE  inventarioprincipal SET CantidadPrincipal =
  :CantidadPrincipal WHERE IdInventarioP = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':CantidadPrincipal', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//--------------------------------Editar la cantidad de productos por articulo
$app -> put('/api/inventarioP/actualizarcantidadart/{FkArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('FkArticulo');
  $cantidad = $request -> getParam('CantidadPrincipal');

  $consulta = "UPDATE  inventarioprincipal SET CantidadPrincipal =
  :CantidadPrincipal WHERE FkArticulo = $articulo";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':CantidadPrincipal', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//------------------------------------------------------------------------------------------------Editar la cantidad de productos por id
$app -> put('/api/inventarioP/aumentarcantidad/{IdInventarioP}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdInventarioP');
  $cantidad = $request -> getParam('CantidadPrincipal');

  $consulta1 = "SELECT CantidadPrincipal FROM inventarioprincipal
  WHERE IdInventarioP = $id";

  try {
    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $ejecutar = $db -> query($consulta1);
      $inventario = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
      $db = null;

      //Exportar y mostrar JSON
      echo json_encode($inventario);

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta = "UPDATE  inventarioprincipal SET CantidadPrincipal =
  :CantidadPrincipal WHERE IdInventarioP = $id";

  if ($inventario >= $cantidad) {
    echo '{"notice": {"text": "Inventario actualizado"}';
  }
  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':CantidadPrincipal', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

//--------------------------------Eliminar inventario
$app -> delete('/api/inventarioP/eliminar/{IdInventarioP}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdInventarioP');

  $consulta = "DELETE FROM inventarioprincipal WHERE IdInventarioP = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Registro de inventario borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }


});


?>
