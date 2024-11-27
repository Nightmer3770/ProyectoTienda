<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "compras");
if (mysqli_connect_errno()) {
    echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $tarjeta = $_POST['tarjeta'];
    $correo = $_POST['correo'];
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    if (count($carrito) > 0) {
        foreach ($carrito as $producto) {
            $idProducto = $producto['id'];
            $cantidad = $producto['cantidad'];
            // Guardar en el historial de compras
            $sql_historial  = "INSERT INTO `historial de compras de los usuarios` (Usuario, `Producto que ha comprado el usuario`, cantidad )
            VALUES ('$idUsuario', '$idProducto', '$cantidad')";    
            mysqli_query($con, $sql_historial);

            //Actualizar el stock
            $sql_stock = "UPDATE productos SET `Cantidad en almacén`= `Cantidad en almacén`-$cantidad
            WHERE `ID Producto` = '$idProducto';";
            mysqli_query($con, $sql_stock);
        }


        // Vaciar el carrito
        unset($_SESSION['carrito']);

        header('Location: ../index.php?mensaje=Compra realizada con éxito');
        exit();
    } else {
        header('Location: carrito.php?mensaje=El carrito está vacío');
        exit();
    }
}
?>
