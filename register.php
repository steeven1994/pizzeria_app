<?php
// pizzeria_app/register.php
// Página para que los nuevos clientes se registren en el sistema.
// Incluye la lógica para procesar el formulario de registro.

require_once 'db.php';   // Incluye la configuración de la base de datos
require_once 'auth.php'; // Incluye las funciones de autenticación

// Si el usuario ya está logueado, redirigir a la página principal.
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$message = ''; // Variable para mensajes de éxito
$error_message = ''; // Variable para mensajes de error

// Procesa el formulario cuando se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    // Validaciones básicas en el servidor
    if (empty($nombre) || empty($correo) || empty($contrasena) || empty($confirmar_contrasena)) {
        $error_message = 'Por favor, completa todos los campos.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Formato de correo electrónico inválido.';
    } elseif ($contrasena !== $confirmar_contrasena) {
        $error_message = 'Las contraseñas no coinciden.';
    } elseif (strlen($contrasena) < 6) {
        $error_message = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        // Intentar registrar al usuario
        try {
            // Verificar si el correo ya existe
            $stmt = $pdo->prepare("SELECT id FROM clientes WHERE correo = ?");
            $stmt->execute([$correo]);
            if ($stmt->fetch()) {
                $error_message = 'Este correo electrónico ya está registrado.';
            } else {
                // Si el correo no existe, proceder con el registro
                if (registerClient($nombre, $correo, $contrasena, $pdo)) {
                    $message = '¡Registro exitoso! Ya puedes iniciar sesión.';
                    // Opcional: Iniciar sesión automáticamente después del registro
                    // loginUser($correo, $contrasena, $pdo);
                    // header("Location: index.php");
                    // exit();
                } else {
                    $error_message = 'Error al registrar el usuario. Inténtalo de nuevo.';
                }
            }
        } catch (\PDOException $e) {
            // Captura cualquier error de la base de datos durante el registro
            $error_message = 'Error en la base de datos: ' . $e->getMessage();
        }
    }
}
?>
<?php require_once 'header.php'; // Incluye la cabecera HTML común ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h2 class="mb-0">Registrarse</h2>
                </div>
                <div class="card-body">
                    <?php if ($message): // Muestra el mensaje de éxito si existe ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $message; ?> <a href="login.php">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>
                    <?php if ($error_message): // Muestra el mensaje de error si existe ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form id="formRegister" method="POST" action="register.php">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrarme</button>
                    </form>
                    <p class="mt-3 text-center">
                        ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; // Incluye el pie de página HTML común ?>