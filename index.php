<?php
session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Oficial</title>
    <link rel="stylesheet" href="css/PF.css">
</head>
<body>
<header class="header">
    <nav class="nav">  <ul> <li>  <a href="index.php">Tienda oficial </a> </li> </ul> </nav> 
    <nav class="nav">
        <ul>
            <li><a href="?deporte=NBA"> NBA </a></li>
            <li><a href="?deporte=NHL"> NHL </a></li>
            <li><a href="?deporte=MLB"> MLB </a></li>
            <li><a href="?deporte=NFL"> NFL </a></li>
            <li><a href="?deporte=Futbol"> Futbol Europeo </a></li>
        </ul>
    </nav>
    <nav class="nav">
        <ul> <li> 
        <?php if ($usuarioLogueado): ?>
        <span>Bienvenido: <?php echo htmlspecialchars($usuarioLogueado['NombreUser']); ?></span>
        <span><a href="php/cerrarsesion.php">Cerrar sesión</a></span>
        <span><a href="php/perfil.php">👤 Mi perfil</a></span>
    <?php else: ?>
        <span><a href="php/iniciarsesion.php">👤 Iniciar sesión</a></span>
    <?php endif; ?>
    <span><a href="php/ver_carrito.php">🛒 Ver carrito (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a></span>
        </ul> </li> 
    </nav>
</header>


<main class="main-content">
    <section class="product-grid">
        <?php
        $con = mysqli_connect("localhost", "root", "", "compras");
        if (mysqli_connect_errno()) {
            echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
        }
        $deporte = isset($_GET['deporte']) ? $_GET['deporte'] : ''; 
        $sql = "SELECT ID_Producto, Nombre, Descripción, Precio, Fotos FROM productos";
        
        if ($deporte) {
            $sql .= " WHERE Deporte = '" . $con->real_escape_string($deporte) . "'";
        }

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                $imgData = base64_encode($row["Fotos"]);
                echo '<img src="data:image/jpeg;base64,' . $imgData . '" alt="' . $row["Nombre"] . '" />';
                echo '<h3>' . $row["Nombre"] . '</h3>';
                echo '<p>' . $row["Descripción"] . '</p>';
                echo '<p>' . number_format($row["Precio"], 2) . ' MXN$</p>';
                echo '<form action="php/carrito.php" method="POST">';
                echo '<input type="hidden" name="imagen_producto" value="' . base64_encode($row["Fotos"]) . '">';
                echo '<input type="hidden" name="id_producto" value="' . $row["ID_Producto"] . '">';
                echo '<input type="hidden" name="nombre_producto" value="' . $row["Nombre"] . '">';
                echo '<input type="hidden" name="precio_producto" value="' . $row["Precio"] . '">';
                echo '<button type="submit">Agregar al carrito</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "No hay productos disponibles.";
        }

        $con->close();
        ?>
    </section>
</main>

</body>
</html>
