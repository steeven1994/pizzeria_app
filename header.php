<?php
// pizzeria_app/header.php
// Este archivo contiene la parte inicial de cada página HTML,
// incluyendo los metadatos, enlaces a hojas de estilo (Bootstrap, CSS personalizado)
// y la barra de navegación (navbar) que se muestra en todo el sitio.

// Iniciar sesión si aún no está iniciada. Esto es crucial para mantener el estado del usuario.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Definir si el usuario está logueado y su rol para personalizar la navegación
$is_logged_in = isset($_SESSION['user_id']);
$user_role = $_SESSION['user_role'] ?? 'guest'; // 'guest' si no hay rol definido

// Determinar la ruta base para los enlaces (importante si el archivo está en subcarpetas como 'admin/')
// Si el script actual está en una subcarpeta como 'admin/', la ruta base será '../' para volver a la raíz.
$base_path = '';
if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
    $base_path = '../';
}
// Puedes añadir más condiciones para 'librarian' o 'reader' si los usas en el futuro
// else if (strpos($_SERVER['REQUEST_URI'], '/librarian/') !== false) {
//     $base_path = '../';
// }
// else if (strpos($_SERVER['REQUEST_URI'], '/reader/') !== false) {
//     $base_path = '../';
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzería Deliciosa</title>
    <!-- Enlace al CSS de Bootstrap 5 para el diseño responsivo y componentes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Enlace a tu archivo CSS personalizado para estilos adicionales. Usa $base_path para la ruta relativa correcta. -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
    <!-- Iconos de Bootstrap (opcional, pero útil para los dashboards) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">🍕 Pizzería Deliciosa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>index.php">Menú</a>
                    </li>
                    <?php if ($is_logged_in && $user_role === 'Cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_path; ?>carrito.php">Mi Carrito <span class="badge bg-light text-danger" id="carrito-contador">0</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_path; ?>historial_pedidos.php">Mis Pedidos</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($is_logged_in && ($user_role === 'Administrador' || $user_role === 'Empleado')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Gestión
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
                                <?php if ($user_role === 'Administrador'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/productos.php">Productos</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/clientes.php">Clientes</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/finanzas.php">Finanzas</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?php echo $base_path; ?>admin/pedidos.php">Pedidos</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! (Rol: <?php echo htmlspecialchars($_SESSION['user_role']); ?>)</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_path; ?>logout.php">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_path; ?>login.php">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_path; ?>register.php">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <!-- El contenido principal de cada página irá aquí -->