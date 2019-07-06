<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


//obetener inventario entero
$app -> get('/api/inventarioS', function(Request $request, Response $response){

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
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

//obetener inventario por categoria
$app -> get('/api/inventarioS/categoria/{NombreCategoria}', function(Request $request, Response $response){

  $categoria = $request -> getAttribute('NombreCategoria');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
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


//obetener inventario por nombre de articulo
$app -> get('/api/inventarioS/articulo/{NombreArticulo}', function(Request $request, Response $response){

  $articulo = $request -> getAttribute('NombreArticulo');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
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

//obetener inventario por codigo
$app -> get('/api/inventarioS/codigo/{Codigo}', function(Request $request, Response $response){

  $codigo = $request -> getAttribute('Codigo');

  $consulta = "select articulo.Codigo, articulo.NombreArticulo,
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

//agregar Productos nuevos
$app -> post('/api/inventarioS/agregarnuevo', function(Request $request, Response $response){

$FkInventario = $request -> getParam('FkInventarioP');
$cantidad = $request -> getParam('CantidadSecundario');

  $consulta = "INSERT INTO inventariosecundario(FkInventarioP, CantidadSecundario)
  values (:FkInventarioP, :CantidadSecundario)";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':FkInventarioP', $FkInventario);
      $stmt -> bindParam(':CantidadSecundario', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Producto nuevo agregado al inventario"}';
      //Exportar y mostrar JSON

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});


//TERMINAR UPDATE CANTIDAD
//Aumentar la cantidad de productos por producto
$app -> put('/api/inventarioS/actualizarcantidad/{FkArticulo}', function(Request $request, Response $response){

  $FkArticulo = $request -> getAttribute('FkArticulo');
  $cantidad = $request -> getParam('CantidadSecundario');

  $consulta1 = "SELECT IdInventarioP FROM inventarioprincipal
  WHERE FkArticulo = $FkArticulo";


  $consulta = "UPDATE inventariosecundario SET CantidadSecundario =
  :CantidadSecundario WHERE FkInventarioP = $consulta1";

  try {

    //Instanciacion de base de datos
      $db = new db();
      $db = $db -> conectar();
      $stmt1 = $db -> prepare($consulta1);
      $stmt = $db -> prepare($consulta);
      $stmt -> bindParam(':CantidadSecundario', $cantidad);
      $stmt -> execute();
      echo '{"notice": {"text": "Inventario actualizado"}';

  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e -> getMessage().'}';
  }

});

?>
