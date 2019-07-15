<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//--------------------------------OBETENER INVENTARIO COMPLETO
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

//--------------------------------OBTENER INVENTARIO POR LA CATEGORIA DE ARTICULO
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

//--------------------------------OBTENER INVENTARIO POR NOMBRE DEL ARTICULO
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

//--------------------------------OBTENER INVENTARIO POR CODIGO
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

//--------------------------------AGREGAR PRODUCTO NUEVO A INVENTARIO PRINCIPAL
$app -> post('/api/inventarioP/agregarnuevo', function(Request $request, Response $response){

$FkArticulo = $request -> getParam('FkArticulo');
$cantidad = $request -> getParam('CantidadPrincipal');
$tipoMovimiento = $request -> getParam('FkTipoMovimiento');

// Valida que no se encuentre ya registrado en el inventario

$consulta1 = "SELECT FkArticulo FROM inventarioprincipal WHERE FkArticulo = $FkArticulo";

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
$Art = $decode[0]['FkArticulo'];

if ($Art > 0) {

  echo '{"error": {"text": "El producto que desea ingresar ya se encuentra registrado en el inventario"}';
  $FkArticulo = null;
  $cantidad = null;
}

//Insert en el inventario

$consulta2 = "INSERT INTO inventarioprincipal(FkArticulo, CantidadPrincipal)
values (:FkArticulo, :CantidadPrincipal)";
//IdMovimientoInventario	FkInventarioP	Cantidad	Fecha	FkUsuario	FkTipoMovimiento

try {

    //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkArticulo', $FkArticulo);
    $stmt -> bindParam(':CantidadPrincipal', $cantidad);
    $stmt -> execute();
    echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';

} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}

// Obtener el id del ultimo insert realizado
$consulta3 = ("SELECT IdInventarioP FROM inventarioprincipal ORDER BY 'FkInventarioP' DESC LIMIT 1");

try {

  //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $ejecutar = $db -> query($consulta3);
    $idInv = $ejecutar -> fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $json = json_encode($idInv);
    echo $json;

} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}

$decode=json_decode($json, true);
$idInv = $decode[0]['IdInventarioP'];
echo $idInv;

// Insert en movimientoinventario

$consulta4 = ("INSERT INTO movimientoinventario(FkInventarioP, Cantidad, Fecha,
FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioP, :Cantidad, :Fecha,
:FkUsuario, :FkTipoMovimiento)");

$fecha = date("Y-m-d");
$usuario = '2';

try {
  $db = new db();
  $db = $db -> conectar();
  $stmt = $db -> prepare($consulta4);
  $stmt -> bindParam(':FkInventarioP', $idInv);
  $stmt -> bindParam(':Cantidad', $cantidad);
  $stmt -> bindParam(':Fecha', $fecha);
  $stmt -> bindParam(':FkUsuario', $usuario);
  $stmt -> bindParam(':FkTipoMovimiento', $tipoMovimiento);
  $stmt -> execute();
    echo '{"notice": {"text": "Movimiento registrado"}';
} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}

});

//--------------------------------EDITAR CANTIDAD DE PRODUCTO POR ID
$app -> put('/api/inventarioP/actualizarcantidad/{IdInventarioP}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdInventarioP');
  $cantidad = $request -> getParam('CantidadPrincipal');
  $tipoMovimiento = $request -> getParam('FkTipoMovimiento');

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

  $consulta2 = ("INSERT INTO movimientoinventario(FkInventarioP, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioP, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  $inventario = $id;
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkInventarioP', $inventario);
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
$app -> put('/api/inventarioP/actualizarcantidadart/{FkArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('FkArticulo');
  $cantidad = $request -> getParam('CantidadPrincipal');
  $tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = ("SELECT IdInventarioP FROM inventarioprincipal WHERE FkArticulo = $articulo
  LIMIT 1");

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
  $id = $decode[0]['IdInventarioP'];

  $consulta2 = "UPDATE  inventarioprincipal SET CantidadPrincipal =
  :CantidadPrincipal WHERE FkArticulo = $articulo";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta2);
      $stmt -> bindParam(':CantidadPrincipal', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

  $consulta3 = ("INSERT INTO movimientoinventario(FkInventarioP, Cantidad, Fecha,
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
$app -> delete('/api/inventarioP/eliminar/{IdInventarioP}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdInventarioP');
$tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = "DELETE FROM inventarioprincipal WHERE IdInventarioP = '$id';";

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

  $consulta2 = ("INSERT INTO movimientoinventario(FkInventarioP, Cantidad, Fecha,
  FkUsuario, FkTipoMovimiento) VALUES (:FkInventarioP, :Cantidad, :Fecha,
  :FkUsuario, :FkTipoMovimiento)");

  $inventario = $id;
  $fecha = date("Y-m-d");
  $usuario = '2';

  try {
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkInventarioP', $inventario);
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
