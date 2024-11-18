<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/PF.css">
</head>
<body>
<header class="header">
    <nav class="nav">
        <ul>
            <li><a href="../index.php"> Tienda oficial  </a></li>
        </ul>
    </nav>
    <div class="user-options">
        <span> <a href="iniciarsesion.php"> 👤 </a> </span>
    </div>
</header>
<?php
session_start(); 
$con = mysqli_connect("localhost", "root", "", "compras");

if (mysqli_connect_errno()) {
    echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['Correo'];
    $pass = $_POST['Contraseña'];
    $sql = "SELECT * FROM usuarios WHERE Correo = '$correo' AND Contraseña = '$pass';";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc(); 
        $_SESSION['usuario'] = $usuario; 
        header("Location: ../index.php");   
        exit(); 
    } else {
        echo "<div class='alert alert-danger text-center' style='margin: 0 auto; width: 50%; text-align: center;'>Error: Usuario no encontrado</div>";
    }
}

$con->close();
?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Crear Cuenta de Usuario</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="Correo" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label"> Contraseña </label>
                        <input type="password" class="form-control" name="Contraseña" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar sesion</button> <br> <br> 
                   <a href="creacionusers.php"> Crear cuenta </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
