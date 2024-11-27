<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];
    $nuevaCantidad = intval($_POST['cantidad']);

    // Validar que la cantidad sea mayor a 0
    if ($nuevaCantidad > 0 && isset($_SESSION['carrito'][$index])) {
        $_SESSION['carrito'][$index]['cantidad'] = $nuevaCantidad;
    }

    // Redirigir al carrito
    header("Location: ver_carrito.php");
    exit();
}
?>
