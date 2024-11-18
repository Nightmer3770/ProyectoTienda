<?php
session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../css/PF.css">
</head>
<body>
<header class="header">
    <nav class="nav">
        <ul>
            <li><a href="../index.php">Tienda oficial</a></li>
        </ul>
    </nav>
</header>

<main class="main-content">
    <h1>Carrito de Compras</h1>
    <?php if (count($carrito) > 0): ?>
        <table>
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
            <tbody>
                <?php 
                $total = 0;
                foreach ($carrito as $index => $producto): 
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                        

                            <?php if (isset($producto['imagen'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-img">
                            <?php else: ?>
                                <img src="../img/placeholder.jpg" alt="Sin imagen" class="product-img">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo number_format($producto['precio'], 2); ?> MXN$</td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($subtotal, 2); ?> MXN$</td>
                        <td class="actions">
                            <form action="eliminar_carrito.php" method="POST">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4">Total</td>
                    <td colspan="2"><?php echo number_format($total, 2); ?> MXN$</td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</main>
</body>
</html>
