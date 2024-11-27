<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];

    // Verificar que el índice existe en el carrito
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]); // Eliminar producto
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el arreglo
    }

    // Redirigir de nuevo al carrito
    header("Location: ver_carrito.php?mensaje=Producto eliminado");
    exit();
}
?>
