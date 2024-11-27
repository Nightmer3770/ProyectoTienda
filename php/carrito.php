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
    // Verifica si el producto ya esta en el carro
    $encontrado = false;
    for ($i = 0; $i < count($_SESSION['carrito']); $i++) {
        if ($_SESSION['carrito'][$i]['id'] == $idProducto) {
            $_SESSION['carrito'][$i]['cantidad'] = $_SESSION['carrito'][$i]['cantidad'] + 1; 
            $encontrado = true;
            break;
        }
    }
    // verifica si es falso, agrega el producto al carro 
    if (!$encontrado) {
        $nuevoProducto = [];
        $nuevoProducto['id'] = $idProducto;
        $nuevoProducto['nombre'] = $nombreProducto;
        $nuevoProducto['precio'] = $precioProducto;
        $nuevoProducto['cantidad'] = 1;
        $nuevoProducto['imagen'] = $imagenProducto;
    
        $_SESSION['carrito'][] = $nuevoProducto;
    }
    
    header("Location: ../index.php?mensaje=Producto agregado al carrito");
    exit();
}
    ?>
    


