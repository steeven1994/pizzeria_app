<?php
// pizzeria_app/index.php
// Página principal de la pizzería que muestra el menú de productos disponibles.

require_once 'db.php';   // Conexión a la base de datos
require_once 'auth.php'; // Funciones de autenticación y sesión

// Obtener todos los productos de la base de datos que estén en stock
// Se selecciona también la columna 'imagen'
try {
    $stmt = $pdo->query("SELECT id, nombre, descripción, precio, stock, imagen FROM productos WHERE stock > 0 ORDER BY nombre ASC");
    $productos = $stmt->fetchAll(); // Obtiene todos los productos como un array de arrays asociativos
} catch (\PDOException $e) {
    // Manejo de errores en caso de que la consulta falle
    echo "<div class='alert alert-danger'>Error al cargar los productos: " . $e->getMessage() . "</div>";
    $productos = []; // Asegura que $productos sea un array vacío en caso de error
}

require_once 'header.php'; // Incluye la cabecera HTML
?>

<main class="container my-4">
    <h1 class="mb-4 text-center text-danger"> Nuestro Delicioso Menú </h1>
    <p class="text-center lead">Explora nuestras pizzas y otros productos.</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (count($productos) > 0): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-danger">
                        <!-- Muestra la imagen del producto. Si 'imagen' está vacío, usa 'default-pizza.jpg' -->
                        <img src="C:\xampp\htdocs\pizzeria_app\assets\img<?php echo htmlspecialchars($producto['imagen'] ?: 'default-pizza.jpg'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-danger"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($producto['descripción']); ?></p>
                            <p class="card-text fs-5 fw-bold text-success">$<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></p>
                            <p class="card-text"><small class="text-muted">Disponibles: <?php echo htmlspecialchars($producto['stock']); ?></small></p>
                            <?php if ($producto['stock'] > 0): ?>
                                <button class="btn btn-danger agregar-carrito" data-id="<?php echo htmlspecialchars($producto['id']); ?>">
                                    Añadir al Carrito
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Agotado</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <p>No hay productos disponibles en este momento. Vuelve pronto!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'footer.php'; // Incluye el pie de página HTML ?>
