<<<<<<< HEAD
<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//--------------------------------OBTENER TODOS LOS MOVIMIENTOS
$app -> get('/api/movimientos', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
from movimientoinventario
INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------OBTENER MOVIMIENTOS POR ID
$app -> get('/api/movimientos/{IdMovimientoInventario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdMovimientoInventario');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento
  WHERE IdMovimientoInventario = $id";

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

//--------------------------------OBTENER TODOS LOS MOVIMIENTOS POR INVENTARIO PRINCIPAL
$app -> get('/api/movimientos/inventario/principal', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------OBTENER TODOS LOS MOVIMIENTOS POR INVENTARIO SECUNDARIO
$app -> get('/api/movimientos/inventario/secundario', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventariosecundario.CantidadSecundario,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventariosecundario on movimientoinventario.FkInventarioS =inventariosecundario.IdInventarioS
  INNER JOIN inventarioprincipal on inventariosecundario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------ELIMINAR MOVIMIENTO
$app -> delete('/api/movimientos/eliminar/{IdMovimientoInventario}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdMovimientoInventario');

$consulta1 = "DELETE FROM movimientoinventario WHERE IdMovimientoInventario = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta1);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Registro de movimiento borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


?>
=======
<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



//--------------------------------OBTENER TODOS LOS MOVIMIENTOS
$app -> get('/api/movimientos', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
from movimientoinventario
INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------OBTENER MOVIMIENTOS POR ID
$app -> get('/api/movimientos/{IdMovimientoInventario}', function(Request $request, Response $response){

  $id = $request -> getAttribute('IdMovimientoInventario');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento
  WHERE IdMovimientoInventario = $id";

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

//--------------------------------OBTENER TODOS LOS MOVIMIENTOS POR INVENTARIO PRINCIPAL
$app -> get('/api/movimientos/inventario/principal', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventarioprincipal.CantidadPrincipal,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventarioprincipal on movimientoinventario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------OBTENER TODOS LOS MOVIMIENTOS POR INVENTARIO SECUNDARIO
$app -> get('/api/movimientos/inventario/secundario', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
  articulo.Costo, articulo.PrecioVenta, articulo.PrecioMayoreo,
  cat_categoriaarticulos.NombreCategoria, inventariosecundario.CantidadSecundario,
  movimientoinventario.Cantidad, movimientoinventario.Fecha, usuario.Nombre,
  tipomovimiento.TipoMovimiento
  from movimientoinventario
  INNER JOIN inventariosecundario on movimientoinventario.FkInventarioS =inventariosecundario.IdInventarioS
  INNER JOIN inventarioprincipal on inventariosecundario.FkInventarioP = inventarioprincipal.IdInventarioP
  INNER JOIN articulo on inventarioprincipal.FkArticulo = articulo.IdArticulo
  INNER JOIN cat_categoriaarticulos on articulo.FkCategoria = cat_categoriaarticulos.IdCategoria
  INNER JOIN usuario on movimientoinventario.FkUsuario = usuario.IdUsuario
  INNER JOIN tipomovimiento on movimientoinventario.FkTipoMovimiento = tipomovimiento.IdTipoMovimiento";

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

//--------------------------------ELIMINAR MOVIMIENTO
$app -> delete('/api/movimientos/eliminar/{IdMovimientoInventario}', function(Request $request, Response $response){

$id = $request -> getAttribute('IdMovimientoInventario');

$consulta1 = "DELETE FROM movimientoinventario WHERE IdMovimientoInventario = '$id';";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> query($consulta1);
      $stmt -> execute();
      $db = null;
      echo '{"notice": {"text": "Registro de movimiento borrado"}';
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


?>
>>>>>>> Actualizacion Arturo. Nuevo push para que Ruben vea version actualizada
