<?php



$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$detalle = isset($_POST['Detalle']) ? $_POST['Detalle'] : '';
$precio = isset($_POST['Precio']) ? $_POST['Precio'] : '';
$conexion->query("INSERT INTO productos ('Nombre', 'Detalle', 'Precio')
VALUES ('$nombre', '$detalle', '$precio')");
?>


