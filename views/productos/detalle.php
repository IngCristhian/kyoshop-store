<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= APP_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= APP_URL ?>/productos">Productos</a></li>
            <li class="breadcrumb-item active"><?= sanitize($producto['nombre']) ?></li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="row mb-5">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <img
                    src="<?= $this->productoModel->obtenerUrlImagen($producto['imagen']) ?>"
                    class="card-img-top"
                    alt="<?= sanitize($producto['nombre']) ?>"
                    style="max-height: 500px; object-fit: contain; padding: 20px;"
                >
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="display-5 fw-bold mb-3"><?= sanitize($producto['nombre']) ?></h1>

            <!-- Product Code -->
            <p class="text-muted">
                <small>Código: <?= sanitize($producto['codigo']) ?></small>
            </p>

            <!-- Price -->
            <div class="mb-4">
                <span class="display-4 text-primary fw-bold">
                    <?= formatPrice($producto['precio']) ?>
                </span>
            </div>

            <!-- Stock Status -->
            <div class="mb-4">
                <?php if ($producto['stock'] > 0): ?>
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-check-circle"></i> En stock (<?= $producto['stock'] ?> disponibles)
                    </span>
                <?php else: ?>
                    <span class="badge bg-danger fs-6">
                        <i class="bi bi-x-circle"></i> Agotado
                    </span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h5>Descripción</h5>
                <p class="text-muted"><?= nl2br(sanitize($producto['descripcion'])) ?></p>
            </div>

            <!-- Actions -->
            <div class="d-grid gap-3">
                <?php if ($producto['stock'] > 0): ?>
                    <!-- Add to Cart -->
                    <div class="row g-2">
                        <div class="col-4">
                            <input
                                type="number"
                                class="form-control"
                                id="cantidad"
                                value="1"
                                min="1"
                                max="<?= $producto['stock'] ?>"
                            >
                        </div>
                        <div class="col-8">
                            <button
                                type="button"
                                class="btn btn-primary btn-lg w-100 btn-add-to-cart"
                                data-product-id="<?= $producto['id'] ?>"
                                data-product-name="<?= sanitize($producto['nombre']) ?>"
                                data-product-price="<?= $producto['precio'] ?>"
                            >
                                <i class="bi bi-cart-plus"></i> Agregar al carrito
                            </button>
                        </div>
                    </div>

                    <!-- Buy Now (WhatsApp) -->
                    <button
                        type="button"
                        class="btn btn-success btn-lg w-100"
                        onclick="comprarPorWhatsApp(<?= htmlspecialchars(json_encode($producto), ENT_QUOTES, 'UTF-8') ?>)"
                    >
                        <i class="bi bi-whatsapp"></i> Comprar por WhatsApp
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="bi bi-x-circle"></i> Producto no disponible
                    </button>

                    <!-- WhatsApp for Availability -->
                    <a
                        href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>?text=Hola%2C%20me%20interesa%20el%20producto%20<?= urlencode($producto['nombre']) ?>%20(código%20<?= $producto['codigo'] ?>).%20¿Cuándo%20estará%20disponible?"
                        target="_blank"
                        class="btn btn-outline-success btn-lg w-100"
                    >
                        <i class="bi bi-whatsapp"></i> Consultar disponibilidad
                    </a>
                <?php endif; ?>
            </div>

            <!-- Additional Info -->
            <div class="alert alert-info mt-4" role="alert">
                <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Información de envío</h6>
                <ul class="mb-0 small">
                    <li>Envío gratis en compras superiores a <?= formatPrice(FREE_SHIPPING_THRESHOLD) ?></li>
                    <li>Medellín: <?= formatPrice(SHIPPING_COST_MEDELLIN) ?></li>
                    <li>Bogotá: <?= formatPrice(SHIPPING_COST_BOGOTA) ?></li>
                    <li>Otras ciudades: <?= formatPrice(SHIPPING_COST_OTHER) ?></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($productosRelacionados)): ?>
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="mb-4">Productos relacionados</h3>
            </div>

            <?php foreach ($productosRelacionados as $related): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <img
                            src="<?= $this->productoModel->obtenerUrlImagen($related['imagen']) ?>"
                            class="card-img-top"
                            alt="<?= sanitize($related['nombre']) ?>"
                            style="height: 200px; object-fit: cover;"
                            loading="lazy"
                        >
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="<?= APP_URL ?>/producto/<?= $related['id'] ?>" class="text-decoration-none text-dark">
                                    <?= sanitize($related['nombre']) ?>
                                </a>
                            </h6>
                            <p class="card-text">
                                <span class="h5 text-primary fw-bold">
                                    <?= formatPrice($related['precio']) ?>
                                </span>
                            </p>
                            <a href="<?= APP_URL ?>/producto/<?= $related['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                                Ver producto
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
/**
 * Función para comprar directamente por WhatsApp
 */
function comprarPorWhatsApp(producto) {
    const cantidad = document.getElementById('cantidad').value || 1;
    const whatsappNumber = '<?= str_replace('+', '', WHATSAPP_NUMBER) ?>';

    const mensaje = `Hola, me interesa este producto:

📦 *${producto.nombre}*
🔢 Código: ${producto.codigo}
💵 Precio: <?= formatPrice('${producto.precio}') ?>
📊 Cantidad: ${cantidad}
💰 Total: <?= formatPrice('${producto.precio * cantidad}') ?>

¿Está disponible?`;

    const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
}
</script>

<style>
.product-card {
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
}
</style>
