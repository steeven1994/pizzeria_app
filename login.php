<?php
// pizzeria_app/login.php
// Página para que los usuarios inicien sesión en el sistema.
// Incluye la lógica para procesar el formulario de inicio de sesión.

require_once 'db.php';   // Incluye el archivo de configuración de la base de datos
require_once 'auth.php'; // Incluye las funciones de autenticación

// Si el usuario ya está logueado, redirigir según su rol.
if (isLoggedIn()) {
    if (isAdmin() || isEmployee()) {
        header("Location: admin/dashboard.php"); // Redirige a los admins/empleados al panel de admin
    } else {
        header("Location: index.php"); // Redirige a los clientes a la página principal
    }
    exit(); // Asegura que el script se detenga después de la redirección
}

$error_message = ''; // Variable para almacenar mensajes de error

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';    // Obtiene el correo del formulario
    $password = $_POST['password'] ?? ''; // Obtiene la contraseña del formulario

    // Intenta iniciar sesión usando la función loginUser
    if (loginUser($correo, $password, $pdo)) {
        // Si el login es exitoso, redirige de nuevo según el rol
        if (isAdmin() || isEmployee()) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        // Si el login falla, establece un mensaje de error
        $error_message = 'Correo o contraseña incorrectos.';
    }
}
?>
<?php require_once 'header.php'; // Incluye la cabecera HTML común ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h2 class="mb-0">Iniciar Sesión</h2>
                </div>
                <div class="card-body">
                    <?php if ($error_message): // Muestra el mensaje de error si existe ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form id="formLogin" method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                    <p class="mt-3 text-center">
                        ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; // Incluye el pie de página HTML común ?>
