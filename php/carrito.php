<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProducto = $_POST['id_producto'];
    $nombreProducto = $_POST['nombre_producto'];
    $precioProducto = $_POST['precio_producto'];
    $imagenProducto = $_POST['imagen_producto'];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    $_SESSION['carrito'][] = [
        'id' => $idProducto,
        'nombre' => $nombreProducto,
        'precio' => $precioProducto,
        'cantidad' => 1,
        'imagen' => $imagenProducto
    ];

    header("Location: ../index.php?mensaje=Producto agregado al carrito");
    exit();
}
?>

