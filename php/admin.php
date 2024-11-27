<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "compras");

if (mysqli_connect_errno()) {
    echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
}

// formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Editar producto existente
    if (isset($_POST['editar_producto'])) {
        $producto_id = $_POST['editar_producto'];
        $nuevo_nombre = $_POST['editar_nombre'];
        $nueva_descripcion = $_POST['editar_descripcion'];
        $nuevo_precio = $_POST['editar_precio'];
        $nuevo_stock = $_POST['editar_stock'];
        $nuevo_origen = $_POST['editar_origen'];
        $nuevo_deporte = $_POST['editar_deporte'];


        $sql_update = "UPDATE productos SET 
        `Nombre` = '$nuevo_nombre', 
        `Descripción` = '$nueva_descripcion', 
        `Precio` = '$nuevo_precio', 
        `Cantidad en almacén` = '$nuevo_stock', 
        `Origen` = '$nuevo_origen', 
        `Deporte` = '$nuevo_deporte' 
        WHERE `ID Producto` = $producto_id";

        mysqli_query($con, $sql_update);
    }

    // Borrar productos 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['borrar_producto'])) {
            $producto_id = $_POST['borrar_producto'];
            $sql = "DELETE FROM productos WHERE `ID Producto` = $producto_id";
            mysqli_query($con, $sql);
        }
    } 
    
    // Agregar nuevos productos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock']) && isset($_FILES['imagen'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $fabricante = $_POST['fabricante'];
            $origen = $_POST['origen'];
            $Deporte = $_POST['deporte'];
            $imagen = $_FILES['imagen'];
            $contenidoimagen = file_get_contents($imagen['tmp_name']);
            $imgBase64 = base64_encode($contenidoimagen);

            $sql = "INSERT INTO productos (Nombre, Descripción, Precio, `Cantidad en almacén`, Fabricante, Origen, Deporte, Fotos) 
                    VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$fabricante' ,'$origen', '$Deporte', '$imgBase64')";
           mysqli_query($con, $sql);
        }
    } 
    
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/PF.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<header class="p-3 bg-dark text-white">
    <div class="container">
        <a href="../index.php" class="navbar-brand text-white">Tienda Oficial</a>
    </div>
</header>

<main class="container my-4">
   

    <!-- Historial de Compras de Todos los Usuarios -->
    <h2>Historial de compras </h2>
    <?php
    $historial_sql = "SELECT  h.`ID compra`, u.`Nombre del usuario`, p.Nombre
                      FROM `historial de compras de los usuarios` h , usuarios u, productos p
                      WHERE h.Usuario = u.`ID usuario` AND h.`Producto que ha comprado el usuario` = p.`ID Producto`;";
    $resultado = $con->query($historial_sql);
    
    if ($resultado->num_rows > 0) {
        echo '<div class ="table-responsive">
        <table class = "table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id compra</th>
                    <th>Usuario</th>
                    <th>Producto comprado</th>
                </tr>
            </thead>
            <tbody>';
        while ($row = $resultado->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['ID compra'] . '</td>
                    <td>' . $row['Nombre del usuario'] . '</td>
                    <td>' . $row['Nombre'] . '</td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<div class='alert alert-warning text-center'>No hay historial de compras.</div>";
    }
    ?>
    <!-- Reporte de Productos -->
    <h2>Reporte de Productos en Inventario</h2>
    <div class="table-responsive"> 
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Origen</th>
            <th>Deporte</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $sql_productos = "SELECT * FROM productos";
            $result_productos = $con->query($sql_productos);

            // Verificar si hay resultados en la consulta
            if ($result_productos->num_rows > 0) {
            $row = $result_productos->fetch_assoc(); // Primera fila
            do {
                $imgData = $row["Fotos"];
                if (base64_decode($imgData, true) === false) {
                    // Si no está en Base64, se codifica
                    $imgData = base64_encode($imgData);
                }
                
                echo '
                <tr>
                <form method="POST" action="" class="d-inline">
                <td>' . $row["ID Producto"] . '
                </td>
                <td>' . $row["Nombre"] . ' <br>
                    <input type="text" name="editar_nombre" value="' . $row["Nombre"] . '" required>
                </td>
                <td> <img src="data:image/jpeg;base64,'  . $imgData . '" class="card-img-top width="300" height="300" /> <br>
                </td>
                <td>' . $row["Descripción"] . ' <br>
                    <input type="text" name="editar_descripcion" value="' . $row["Descripción"] . '" required>
                </td>
                <td>' . $row["Precio"] . ' <br>
                    <input type="number" name="editar_precio" value="' . $row["Precio"] . '" required> MXN$
                </td>
                <td>' . $row["Cantidad en almacén"] . ' <br>
                    <input type="number" name="editar_stock" value="' . $row["Cantidad en almacén"] . '" required>
                </td>
                <td>' . $row["Origen"] . ' <br>
                    <input type="text" name="editar_origen" value="' . $row["Origen"] . '" required> 
                </td>
                <td>' . $row["Deporte"] . ' <br>
                    <input type="text" name="editar_deporte" value="' . $row["Deporte"] . '" required> 
                </td>
                <td>
                    <input type="hidden" name="editar_producto" value="' . $row["ID Producto"] . '">
                    <button type="submit" class="btn btn-warning btn-sm">Editar</button> <br>
                    
                </td>
                </form>
                <form method="POST" action="">
                <td>
                <input type="hidden" name="borrar_producto" value="'. $row["ID Producto"] .'">
                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                </td>
                </form>
                </tr>
                '
                ;
                $row = $result_productos->fetch_assoc(); // Siguiente fila
            } while ($row); // Repite mientras existan filas
            } else {
                echo '<tr><td colspan="6">No hay productos registrados en la base de datos.</td></tr>';
            }
        ?>

        </tbody>
    </table>
        </div>

    <!-- Agregar nuevo producto -->
    <h3>Agregar nuevo producto</h3>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" name="precio" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="fabricante" class="form-label">Fabricante</label>
            <input type="text" class="form-control" name="fabricante" required>
        </div>
        <div class="mb-3">
            <label for="origen" class="form-label">Origen</label>
            <input type="text" class="form-control" name="origen" required>
        </div>
        <div class="mb-3">
            <label for="deporte" class="form-label">Deporte</label>
            <input type="text" class="form-control" name="deporte" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-success">Agregar Producto</button>
    </form>
</main>


</body>
</html>
