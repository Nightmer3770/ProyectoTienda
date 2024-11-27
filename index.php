<?php
session_start();

if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = [];
}

if (isset($_SESSION['usuario'])) {
    $usuarioLogueado = $_SESSION['usuario'];
} else {
    $usuarioLogueado = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Oficial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/PF.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <h3 class="mb-0">Tienda Oficial</h3>
            </a>
            <nav class="nav nav-pills flex-column flex-sm-row">
                <a href="?deporte=NBA" class="nav-link px-2 text-white">NBA</a>
                <a href="?deporte=NHL" class="nav-link px-2 text-white">NHL</a>
                <a href="?deporte=MLB" class="nav-link px-2 text-white">MLB</a>
                <a href="?deporte=NFL" class="nav-link px-2 text-white">NFL</a>
                <a href="?deporte=Futbol" class="nav-link px-2 text-white">Fútbol</a>
            </nav>
            <div class="text-end">
            <?php 
            // Si el usuario esta logueado 
                if ($usuarioLogueado) {
                    echo "<span class='text-white me-3'>Bienvenido: {$usuarioLogueado['Nombre del usuario']}</span>";
                    echo "<a href='php/perfil.php' class='btn btn-outline-light me-2'>👤 Mi perfil</a>";
                    echo "<a href='php/admin.php' class='btn btn-outline-light me-2'>🔧 Administración</a>";
                }else {
                    echo "<a href='php/iniciarsesion.php' class='btn btn-outline-light me-2'>👤 Iniciar sesión</a>";
                }
                // Si el carrito existe cuenta los productos
                if (isset($_SESSION['carrito'])) {
                $carritoCount = count($_SESSION['carrito']);
                } else {
                $carritoCount = 0;
                }
                echo "<a href='php/ver_carrito.php' class='btn btn-warning'>🛒 Carrito ($carritoCount)</a>";
            ?>

            </div>
        </div>
    </div>
</header>

<main class="container my-4">

    <h1 class="text-primary text-center fw-bold"> Catalogo de productos </h1>

    <div class="row">
        <?php
        $con = mysqli_connect("localhost", "root", "", "compras");
        if (mysqli_connect_errno()) {
            echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
        }
        // Ver el campo deporte
        if (isset($_GET['deporte'])) {
            $deporte = $_GET['deporte'];
        } else {
            $deporte = '';
        }

        // Mostrar los productos
        $sql = "SELECT `ID Producto`, Nombre, Descripción, Precio, Fotos , Fabricante, Origen FROM productos";
        if ($deporte != '') {
            $sql .= " WHERE Deporte = '" . $deporte . "'";
        }
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 mb-4">';
                echo '<div class="card h-100">';
        
                // Ver si la imagen está en formato Base64
                $imgData = $row["Fotos"];
                if (base64_decode($imgData, true) === false) {
                    // Si no está en Base64, se codifica
                    $imgData = base64_encode($imgData);
                }
                echo '<div class="card-body d-flex flex-column">';
                echo '<img src="data:image/jpeg;base64,' . $imgData . '" class="card-img-top width="300" height="300" />';
                echo '<h5 class="text-primary fw-bold text-center my-3">' . $row["Nombre"] . '</h5>';
                echo '<p class="card-text text-center my-3">' . $row["Descripción"] . '</p>';
                echo '<p class="card-text text-center my-3"> Fabricante: ' . $row["Fabricante"] . '</p>';
                echo '<p class="card-text text-center my-3"> Origen: ' . $row["Origen"] . '</p>';
                echo '<p class="card-text text-center my-3">' . $row["Precio"] . ' MXN$</p>';
        
                // Formulario para agregar al carrito
                echo '<form action="php/carrito.php" method="POST" class="mt-auto">';
                echo '<input type="hidden" name="imagen_producto" value="' . $imgData . '">';
                echo '<input type="hidden" name="id_producto" value="' . $row["ID Producto"] . '">';
                echo '<input type="hidden" name="nombre_producto" value="' . $row["Nombre"] . '">';
                echo '<input type="hidden" name="precio_producto" value="' . $row["Precio"] . '">';
                echo '<button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>';
                echo '</form>';
        
                echo '</div> 
                 </div> 
                </div>'; 
            }
        }
        
        
        else {
            echo "<div class='alert alert-warning text-center'>No hay productos disponibles.</div>";
        }
        $con->close();
        ?>
    </div>
    <h1 class="text-primary text-center fw-bold"> Noticias destacadas  </h1>
    <!--NFL INFO -->
    <div class="row align-items-center bg-light p-4 mb-5">
        <div class="col-md-6 text-center">
            <img src="img/ChfiefsCam.png" class="img-fluid" style="max-width: 80%; height: auto;">
        </div>
        <div class="col-md-6">
            <h3 class="text-primary fw-bold"> Historia NFL </h3>
            <p class="mt-3">
                El Super Bowl LVIII fue el 58.º Super Bowl y se llevó a cabo el 11 de febrero de 2024 
                en el Allegiant Stadium de Paradise, Nevada. El equipo local fue 
                los Kansas City Chiefs, quienes revalidaron el título al imponerse a los San Francisco 49ers.

                Aquí tenemos su playera ¡Consíguela antes de que se acaben! 
            </p>
        </div>
    </div>
    <!--NBA INFO -->
    <div class="row align-items-center bg-light p-4 mb-5">
        <div class="col-md-6 text-center">
            <img src="img/LBJ.png" class="img-fluid" style="max-width: 80%; height: auto;">
        </div>
        <div class="col-md-6">
            <h3 class="text-primary fw-bold"> Record Historico en NBA  </h3>
            <p class="mt-3">
            LeBron James, jugador de la NBA, ha anotado 40.777 puntos en la liga hasta el inicio de la temporada 2024-2025. 
            Su promedio de anotación es de 27,1 puntos por partido

            Aquí tenemos la sudadera de su actual equipo Los Angeles Lakers
            ¡Consíguela antes de que se acaben! 
            </p>
        </div>
    </div>
    <!--MLB INFO -->
    <div class="row align-items-center bg-light p-4 mb-5">
        <div class="col-md-6 text-center">
            <img src="img/LAD.png" class="img-fluid" style="max-width: 80%; height: auto;">
        </div>
        <div class="col-md-6">
            <h3 class="text-primary fw-bold"> Cayo el 8 Anillo  </h3>
            <p class="mt-3">
            El conjunto de Los Angeles Dodgers derrotaron a su antiguo rival los New York Yankees en una emocionante Serie Mundial
            donde Los Angeles consiguieron su 8 anillo al imponerse en un total de 5 juegos, donde el marcador global
            fue de 4-1.

            Aquí tenemos la gorra oficial del campeonato de Los Angeles Dodgers
            ¡Consíguela antes de que se acaben! 
            </p>
        </div>
    </div>
</main>

<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Información de contacto</h5>
                <p>Dirección: Calle 635 # 18</p>
                <p>Teléfono: +52 5561 7869</p>
                <p>Email: luis_rocha@anahuac.mx</p>
            </div>
            <div class="col-md-6">
                <h5>Acerca de este sitio</h5>
                <p>Este sitio ofrece productos deportivos oficiales de diversas ligas. Encuentra todo lo necesario para apoyar a tu equipo favorito.</p>
                <!-- Iconos de redes sociales -->
                <div class="mt-3">
                    <a href="https://www.instagram.com/rocha__lrb/" target="_blank" class="text-white me-3">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100024840555586" target="_blank" class="text-white me-3">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/luis-roberto-rocha-barr%C3%B3n-60252b264/" target="_blank" class="text-white">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
