<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];

    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); 
    }

    header("Location: ver_carrito.php?mensaje=Producto eliminado");
    exit();
}