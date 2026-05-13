<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['codigo'])){
    $codigo = $_POST['codigo'];
    $cantidad = isset($_POST['cantidad']) ? (int)  $_POST['cantidad'] : 1;

if(!isset($_SESSION['carrito'])){
$_SESSION['carrito'] = [];

}
if (isset($_SESSION['carrito'][$codigo])){
$_SESSION['carrito'][$codigo] += $cantidad;
}else {
$_SESSION['carrito'][$codigo] = $cantidad;
}

}
 $totalProductos = isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalogo</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
<h1>Solicite los productos de su Preferencia</h1>
<div>

<a href="carrito.php">
<img src="https://cdn-icons-png.flaticon.com/512/6680/6680353.png" alt="carrito" width="60px">

<span><?php echo $totalProductos; ?></span>
</a>

</div>
</header>
<div>
    <ul>
<?php
$host = "localhost";
$user = "root";
$password = "";
$databas = "tienda";

$conexion = new mysqli( $host, $user ,$password, $databas);

if ($conexion->connect_error) {

    die("Error al conectar a la base de datos: " . $conexion->connect_error);

}



$resultado = $conexion->query("SELECT * FROM Productos");
$query = "select codigo, nombre, detalle, imagen, precio from productos";
$stmt = $conexion->prepare($query);
$stmt->execute();
$resultado = $stmt->get_result();







if($resultado->num_rows > 0) {

while($row = $resultado->fetch_assoc()){

    $codigo = $row["codigo"];
    $nombre = htmlspecialchars($row["nombre"]);
    $detalle = htmlspecialchars($row["detalle"]);
    $imagen = htmlspecialchars($row["imagen"]);
    $precio =  htmlspecialchars($row["precio"]);



echo "<li>";
echo "<h2>" .$nombre ."<h2>";
echo"<p>" . $detalle . "</p>";
echo "<img src='" . $imagen . "' alt='" . $row["nombre"] . "' width='300' >";
echo"<p>Precio: $" . $precio . "</p>";
echo"<form method='POST' action=''>";
echo"<input type='hidden'name='codigo' value='".$codigo . "'>";
echo"<label for='cantidad'>Cantidad:</label>";
echo"<input type='number' name='cantidad' id='cantidad' value='1' min'1'>";
echo "<button type='submit'>Agregar al carrito</button>";
echo"</form>";
echo"</li>";
}
}else {
echo "<li>Hay producto disponible <?>";
}               

                
                $stmt->close();
                $conexion->close();
            ?>
        </ul>
    </div>
</body>
</html>