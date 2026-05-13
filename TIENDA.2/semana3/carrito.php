<?php

session_start();
if(isset($_POST["vaciar"])){
unset($_SESSION["carrito"]);
header("Location: carrito.php");
exit();
}




$host = "localhost";
$user = "root";
$password = "";
$databas = "tienda";

$conexion = new mysqli( $host, $user ,$password, $databas);

if ($conexion->connect_error) {

    die("Error al conectar " . $conexion->connect_error);

}

$carrito = $_SESSION["carrito"] ?? [];



$productos = [];

if (!empty($carrito)){
    $id = implode(",", array_keys($carrito));

    $query = "SELECT codigo, nombre, detalle, imagen, precio FROM productos WHERE codigo IN($id)";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()){
$id = $row["codigo"];
$row['cantidad'] = $carrito[$id];
$productos[] = $row;


    }

}

$conexion->close();
$total = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
<h1>carrito de compras</h1>
<a href="catalogo.php"> Volver a la tienda</a>
</header>


<?php if (empty($productos)) : ?>
    <p>El carrito esta vasio</p>


<?php else: ?>



<div>
    <ul>
<?php foreach  ($productos as $producto):

$subtotal = $producto["precio"] * $producto["cantidad"];
$total += $subtotal;



?>

<li>

<img src="<?php echo htmlspecialchars($producto['imagen']);?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" width="100">
<h2><?php echo htmlspecialchars($producto['nombre']);?> </h2>
<p><?php echo htmlspecialchars($producto['detalle']);?></p>
<p>Precio Unitario: $<?php echo number_format($producto['precio'], 2); ?></p>
<p>Cantidad:<?php echo $producto['cantidad']; ?></p>
<p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
</li>



<?php endforeach; ?>

<?php endif; ?>
        </ul>
        <p><strong>Total $<?php echo number_format($total, 2); ?></strong></p>
    </div>
    <form action="POST">

    <button type="submit" name="vaciar"> Vaciar carrito</button>
    </form>
</body>
</html>
   