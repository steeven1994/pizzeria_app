<?php
// pizzeria_app/db.php
// Este archivo establece la conexión a la base de datos MySQL utilizando PDO.

// Configuración de los parámetros de conexión a la base de datos
$host = 'localhost'; // El host de la base de datos (generalmente 'localhost' para XAMPP)
$db   = 'pizzeria_db'; // ¡IMPORTANTE! Reemplaza 'pizzeria_db' con el nombre exacto de tu base de datos en phpMyAdmin
$user = 'root';      // Usuario de la base de datos (por defecto 'root' en XAMPP)
$pass = '';          // Contraseña del usuario de la base de datos (por defecto vacía en XAMPP)
$charset = 'utf8mb4'; // Codificación de caracteres para la base de datos

// Construcción del DSN (Data Source Name) para la conexión PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones para la conexión PDO
$options = [
    // Lanza excepciones en caso de errores SQL, lo que facilita la depuración
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Define el modo de obtención de resultados por defecto (arrays asociativos)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Deshabilita la emulación de prepares para mayor seguridad y rendimiento
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Intenta crear una nueva instancia de PDO para conectar a la base de datos
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Si la conexión falla, se captura la excepción y se muestra un mensaje de error.
    // Esto es crucial para identificar problemas de conexión en las primeras etapas.
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>