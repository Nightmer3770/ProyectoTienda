<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "compras");
if (mysqli_connect_errno()) {
    echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
}

if (isset($_SESSION['usuario'])) {
    $usuarioLogueado = $_SESSION['usuario'];
} else {
    $usuarioLogueado = null;
}

$idUsuario = $usuarioLogueado['ID Usuario'];

// Obtener historial de compras
$sql = "SELECT p.Nombre, p.Precio , h.Cantidad
        FROM `historial de compras de los usuarios` h, productos p
        WHERE h.`Producto que ha comprado el usuario` = p.`ID Producto`
        AND h.Usuario = '$idUsuario'";
$result = mysqli_query($con, $sql);
$historial = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="../css/PF.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="../index.php" class="navbar-brand text-white">Tienda Oficial</a>
                <div>
                    <a href="cerrarsesion.php" class="btn btn-warning">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </header>


    <main class="main-content">
    <?php
        echo '<div class="form-card">
        <h2>Información del Usuario</h2>
        <p><strong>ID:</strong> ' .($usuarioLogueado['ID Usuario']) . '</p
        <p><strong>Nombre:</strong> ' .($usuarioLogueado['Nombre del usuario']) . '</p>
        <p><strong>Correo:</strong> ' .($usuarioLogueado['Correo electrónico']) . '</p>
        <p><strong>Tarjeta:</strong> ' .($usuarioLogueado['Numero de tarjeta bancaria']) . '</p>
        <p><strong>Dirección:</strong> ' .($usuarioLogueado['Dirección Postal']) . '</p>
        </div>';
    ?>

        <div class="form-card">
            <h2>Historial de Compras</h2>
            <?php 
                if (count($historial) > 0) { 
                    echo '<table>
                        <thead>
                            <tr>
                                <th> Producto </th>
                                <th> Precio </th>
                                <th> Cantidad </th>
                            </tr>
                        </thead>
                        <tbody>';
                    $compra = $historial;
                    foreach ($compra as $elementoprod) { 
                        echo '<tr>
                        <td>' . $elementoprod['Nombre'] . '</td>
                        <td>' . $elementoprod['Precio'] . '</td>
                        <td>' . $elementoprod['Cantidad'] . '</td>
                      </tr>';
                    }
                } else { 
                    echo '<p>No hay historial de compras.</p>';
                }
                ?>
        </div>

    </main>

</body>
</html>
