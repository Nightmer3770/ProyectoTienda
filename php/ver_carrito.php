<?php
session_start();
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = [];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../css/PF.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="../index.php"  class="navbar-brand text-white"> Tienda oficial  </a>
            </div>
        </div>
</header>

<main class="main-content">
    <h1>Carrito de Compras</h1>
    <?php 
    if (count($carrito) > 0) {
        $total = 0;
        echo '<table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';
    
        foreach ($carrito as $index => $producto) {
            $subtotal = $producto['precio'] * $producto['cantidad'];
            $total =$total +$subtotal;
    
            if (!empty($producto['imagen'])) {
                $imagen = "data:image/jpeg;base64," . $producto['imagen'];
            } else {
                $imagen = "../img/placeholder.jpg";
            }
            
    
            echo '<tr>
                    <td><img src="' . $imagen . '" class="product-img"></td>
                    <td>' . $producto['nombre'] . '</td>
                    <td>' . $producto['precio'] . ' MXN$</td>
                    <td>' . $producto['cantidad'] . '</td>
                    <td>' . $subtotal . ' MXN$</td>
                    <td>
                        <form action="actualizar_carrito.php" method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="' . $index . '">
                            <input type="number" name="cantidad" value="' . $producto['cantidad'] . '" min="1" class="cantidad-input">
                            <button type="submit" class="delete-btn">Actualizar</button>
                        </form>
                        <form action="eliminar_carrito.php" method="POST" style="display:inline;">
                            <input type="hidden" name="index" value="' . $index . '">
                            <button type="submit" class="delete-btn">Eliminar</button>
                        </form>
                    </td>
                </tr>';
        }
        
        echo '</tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4">Total</td>
                    <td colspan="2">' . $total . ' MXN$</td>
                </tr>
            </tfoot>
        </table>';
        echo '<div id="formPagar">
            <div class="alert alert-success"> El ID se encuentra en la pagina de Mi perfil </div>
            <form action="procesar_pago.php" method="POST">
                <label for="id_usuario">ID Usuario:</label>
                <input type="text" name="id_usuario" id="id_usuario" placeholder="Ingresa tu ID de usuario" required>
    
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingresa tu nombre completo" required>
    
                <label for="tarjeta">Número de tarjeta:</label>
                <input type="text" name="tarjeta" id="tarjeta" placeholder="16 dígitos de tu tarjeta" maxlength="16" required>
    
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" placeholder="Ingresa tu correo electrónico" required>
    
                <button type="submit" class="delete-btn">Finalizar compra</button>
            </form>
        </div>';
    } else {
        echo ' <br> <br> <h1> (No hay productos en el carrito)</h1>';
    }    
    ?>
</main>

</body>
</html>
