<?php
// pizzeria_app/auth.php
// Este archivo contiene funciones esenciales para la autenticación de usuarios
// y la gestión de sesiones, incluyendo login, registro, verificación de rol y logout.

// Iniciar sesión si aún no está iniciada. Debe ser lo primero en cualquier script que use sesiones.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Intenta iniciar sesión de un usuario.
 * Verifica las credenciales proporcionadas con la base de datos.
 * @param string $correo El correo electrónico del usuario.
 * @param string $password La contraseña en texto plano.
 * @param PDO $pdo Objeto PDO para la conexión a la base de datos.
 * @return bool True si el inicio de sesión fue exitoso, false en caso contrario.
 */
function loginUser($correo, $password, $pdo) {
    // Prepara una consulta SQL para buscar el usuario por su correo.
    // Se une con la tabla 'roles' para obtener el nombre del rol.
    $stmt = $pdo->prepare("SELECT c.id, c.nombre, c.correo, c.contraseña, r.nombre as rol_nombre FROM clientes c JOIN roles r ON c.rol_id = r.id WHERE c.correo = ?");
    $stmt->execute([$correo]); // Ejecuta la consulta con el correo como parámetro
    $user = $stmt->fetch(); // Obtiene la fila del usuario como un array asociativo

    // Verifica si se encontró un usuario y si la contraseña proporcionada
    // coincide con el hash almacenado en la base de datos.
    if ($user && password_verify($password, $user['contraseña'])) {
        // Si las credenciales son correctas, almacena información del usuario en la sesión.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_role'] = $user['rol_nombre']; // 'Administrador', 'Empleado' o 'Cliente'
        return true; // Inicio de sesión exitoso
    }
    return false; // Credenciales incorrectas
}

/**
 * Registra un nuevo usuario cliente en la base de datos.
 * Las contraseñas se hashean para seguridad.
 * Asigna el rol_id 3, que corresponde a 'Cliente' por defecto en la tabla 'roles'.
 * @param string $nombre Nombre del cliente.
 * @param string $correo Correo electrónico (debe ser único).
 * @param string $password Contraseña en texto plano.
 * @param PDO $pdo Objeto PDO para la conexión a la base de datos.
 * @return bool True si el registro fue exitoso, false en caso contrario.
 */
function registerClient($nombre, $correo, $password, $pdo) {
    // Hashea la contraseña antes de guardarla.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepara una consulta para insertar un nuevo cliente.
    $stmt = $pdo->prepare("INSERT INTO clientes (nombre, correo, contraseña, rol_id) VALUES (?, ?, ?, 3)");
    // Ejecuta la consulta con los datos del nuevo cliente.
    return $stmt->execute([$nombre, $correo, $hashed_password]);
}

/**
 * Verifica si un usuario está actualmente logueado.
 * @return bool True si hay un 'user_id' en la sesión, false en caso contrario.
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Verifica si el usuario logueado tiene el rol de Administrador.
 * @return bool True si el usuario es Administrador, false en caso contrario.
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user_role'] === 'Administrador';
}

/**
 * Verifica si el usuario logueado tiene el rol de Empleado.
 * @return bool True si el usuario es Empleado, false en caso contrario.
 */
function isEmployee() {
    return isLoggedIn() && $_SESSION['user_role'] === 'Empleado';
}

/**
 * Cierra la sesión del usuario actual.
 * Destruye todas las variables de sesión y la sesión misma.
 */
function logoutUser() {
    // Elimina todas las variables de la sesión actual.
    session_unset();
    // Destruye la sesión.
    session_destroy();
    // Redirige al usuario a la página de inicio de sesión.
    header("Location: login.php"); // Redirige a login.php que está en la misma raíz
    exit(); // Termina la ejecución del script
}
?>