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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Crear Cuenta de Usuario</h2>
                <?php
                $con = mysqli_connect("localhost", "root", "", "compras");
                if (mysqli_connect_errno()) {
                    echo "<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>";
                }
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nombre = $_POST['NombreUser'];
                    $correo = $_POST['Correo'];
                    $contrasena = $_POST['Contraseña'];
                    $fecha_nacimiento = $_POST['FDN'];
                    $tarjeta = $_POST['Tarjeta'];
                    $direccion = $_POST['Dirección'];
                    $sql = "INSERT INTO usuarios (NombreUser, Correo, Contraseña , FDN , Tarjeta , Dirección)
                            VALUES ('$nombre', '$correo', '$contrasena', '$fecha_nacimiento', '$tarjeta', '$direccion')";

                
                    if ($con->query($sql) === TRUE) {
                        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                        exit(); 
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $con->error . "</div>";
                    }
                }

                
                if (isset($_GET['success'])) {
                    echo "<div class='alert alert-success text-center' role='alert'>
                            <strong>¡Éxito!</strong> Nuevo registro creado exitosamente.
                          </div>";
                }

                $con->close();
                ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="NombreUser" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="Correo" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="Contraseña" placeholder="Crea una contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="FDN" required>
                    </div>
                    <div class="mb-3">
                        <label for="tarjeta" class="form-label">Número de Tarjeta Bancaria</label>
                        <input type="text" class="form-control" name="Tarjeta" placeholder="Ingresa el número de tarjeta" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionPostal" class="form-label">Dirección Postal</label>
                        <input type="text" class="form-control" name="Dirección" placeholder="Ingresa tu dirección postal" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button> <br> <br> 
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        if (window.location.search.includes('success=1')) {
            const url = new URL(window.location);
            url.searchParams.delete('success'); 
            window.history.replaceState(null, null, url); 
        }
    </script>
</body>
</html>
