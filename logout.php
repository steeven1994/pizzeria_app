<?php
// pizzeria_app/logout.php
// Script para cerrar la sesión del usuario actual.

require_once 'auth.php'; // Necesita auth.php para la función logoutUser()

logoutUser(); // Llama a la función para cerrar la sesión y redirigir
?>
