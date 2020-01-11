<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//--------------------------------OBETENER INVENTARIO COMPLETO
$app -> get('/api/inventarioD', function(Request $request, Response $response){

  $consulta = "SELECT
            inventariodevolucion.IdInventarioD,
            inventariodevolucion.FkDevolucion,
            devolucion.FkVenta,
            venta.FkSubVenta,
            subventa.FkArticulo,
            articulo.NombreArticulo,
            articulo.Codigo,
            devolucion.EstadoArticulo,
            articulo.Costo,
            articulo.PrecioVenta,
            articulo.PrecioMayoreo,
            articulo.FkCategoria,
            cat_categoriaarticulos.NombreCategoria
            FROM
            inventariodevolucion
            INNER JOIN devolucion ON inventariodevolucion.FkDevolucion = devolucion.IdDevolucion
            INNER JOIN venta ON devolucion.FkVenta = venta.IdVenta
            INNER JOIN subventa ON venta.FkSubVenta = subventa.IdSubVenta
            INNER JOIN articulo ON subventa.FkArticulo = articulo.IdArticulo
            INNER JOIN cat_categoriaarticulos ON articulo.FkCategoria = cat_categoriaarticulos.IdCategoria";

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
$app -> post('/api/inventarioD/agregarnuevo', function(Request $request, Response $response){

$devolucion = $request -> getParam('FkDevolucion');
$cantidad = $request -> getParam('CantidadDevolucion');

// Valida que no se encuentre ya registrado en el inventario

$consulta1 = "SELECT EXISTS(SELECT FkDevolucion FROM inventariodevolucion WHERE FkDevolucion = $devolucion)";

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
$idInv = $decode[0]['FkDevolucion'];

if ($idInv >= 1) {
  echo '{"error": {"text": "El producto que desea ingresar ya se encuentra registrado en el inventario"}';
  $devolucion = null;
  $cantidad = null;
}

//Insert en el inventario

$consulta2 = "INSERT INTO inventariodevolucion(FkDevolucion, CantidadDevolucion)
values (:FkDevolucion, :CantidadDevolucion)";
//IdMovimientoInventario	FkInventarioP	Cantidad	Fecha	FkUsuario	FkTipoMovimiento

try {

    //Instanciacion de base de datos
    $db = new db();
    $db = $db -> conectar();
    $stmt = $db -> prepare($consulta2);
    $stmt -> bindParam(':FkDevolucion', $devolucion);
    $stmt -> bindParam(':CantidadDevolucion', $cantidad);
    $stmt -> execute();
    echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';

} catch (PDOException $e) {
  echo '{"error": {"text": '.$e -> getMessage().'}';
}

});

//--------------------------------EDITAR CANTIDAD DE PRODUCTO POR ID
$app -> put('/api/inventarioD/actualizarcantidad/{IdInventarioD}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdInventarioD');
  $cantidad = $request -> getParam('CantidadDevolucion');

  $consulta = "UPDATE  inventariodevolucion SET CantidadDevolucion =
  :CantidadDevolucion WHERE IdInventarioD = $id";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':CantidadDevolucion', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//--------------------------------ELIMINAR PRODUCTO DE INVENTARIO
$app -> delete('/api/inventarioD/eliminar/{IdInventarioD}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdInventarioD');
$tipoMovimiento = $request -> getParam('FkTipoMovimiento');

  $consulta1 = "DELETE FROM inventariodevolucion WHERE IdInventarioD = '$id';";

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

});

?>
