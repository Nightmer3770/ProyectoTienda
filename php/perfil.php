<?php
    session_start();
    $usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
?>

<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Perfil del Usuario</title>
            <link rel="stylesheet" href="../css/PF.css">
        </head>
        <body>
            <header class="header">
                <nav class="nav">
                    <ul>
                        <li><a href="../index.php">Tienda oficial</a></li>
                    </ul>
                </nav>
                <nav class="nav">
                    <ul> <li> 
                    <?php if ($usuarioLogueado): ?>
                    <span>Bienvenido: <?php echo htmlspecialchars($usuarioLogueado['NombreUser']); ?></span>
                    <span><a href="cerrarsesion.php">Cerrar sesión</a></span>
                    <?php else: ?>
                    <?php endif; ?>
                    <span>🛒</span>
                    </ul> </li> 
                </nav>
            </header>

            <main class="main-content">
                <div class="form-card">
                    <h2>Información del Usuario</h2>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuarioLogueado['NombreUser']); ?></p>
                    <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuarioLogueado['Correo']); ?></p>
                    <p><strong>Tarjeta:</strong> <?php echo htmlspecialchars($usuarioLogueado['Tarjeta']); ?></p>
                    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($usuarioLogueado['Dirección']); ?></p>
                </div>
            </main>
        </body>
    </html>
