<?php
// pizzeria_app/footer.php
// Este archivo contiene la parte final de cada página HTML,
// incluyendo el pie de página y los enlaces a los archivos JavaScript necesarios.

// Determinar la ruta base para los scripts (importante si el archivo está en subcarpetas)
$base_path = '';
if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
    $base_path = '../';
}
// Puedes añadir más condiciones para 'librarian' o 'reader' si los usas
?>
        <!-- El contenido principal de cada página termina aquí -->
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <p>&copy; <?php echo date("Y"); ?> Pizzería Deliciosa. Todos los derechos reservados.</p>
    </footer>

    <!-- Enlace al bundle de JavaScript de Bootstrap 5 (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Enlace a tu archivo JavaScript personalizado para interactividad adicional. Usa $base_path para la ruta relativa correcta. -->
    <script src="<?php echo $base_path; ?>assets/js/script.js"></script>
</body>
</html>
