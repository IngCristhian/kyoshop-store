<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold">Catálogo de Productos</h1>
            <p class="text-muted">Descubre nuestra colección de ropa</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="<?= APP_URL ?>/productos" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Buscar productos..."
                    value="<?= sanitize($search ?? '') ?>"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <?php if (!empty($search)): ?>
                <a href="<?= APP_URL ?>/productos" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar búsqueda
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Products Grid -->
    <?php if (empty($productos)): ?>
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
            <h4>No se encontraron productos</h4>
            <p class="mb-0">
                <?php if (!empty($search)): ?>
                    Intenta con otra búsqueda o <a href="<?= APP_URL ?>/productos">ver todos los productos</a>
                <?php else: ?>
                    Estamos trabajando en traerte los mejores productos. ¡Vuelve pronto!
                <?php endif; ?>
            </p>
        </div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm product-card">
                        <!-- Product Image -->
                        <div class="position-relative">
                            <img
                                src="<?= $this->productoModel->obtenerUrlImagen($producto['imagen']) ?>"
                                class="card-img-top"
                                alt="<?= sanitize($producto['nombre']) ?>"
                                style="height: 250px; object-fit: cover;"
                                loading="lazy"
                            >

                            <!-- Stock Badge -->
                            <?php if ($producto['stock'] <= 0): ?>
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                                    Agotado
                                </span>
                            <?php elseif ($producto['stock'] <= 5): ?>
                                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">
                                    Últimas unidades
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <!-- Product Name -->
                            <h5 class="card-title">
                                <a href="<?= APP_URL ?>/producto/<?= $producto['id'] ?>" class="text-decoration-none text-dark">
                                    <?= sanitize($producto['nombre']) ?>
                                </a>
                            </h5>

                            <!-- Product Description (truncated) -->
                            <p class="card-text text-muted small flex-grow-1">
                                <?= sanitize(substr($producto['descripcion'], 0, 80)) ?>...
                            </p>

                            <!-- Price -->
                            <div class="mb-3">
                                <span class="h4 text-primary fw-bold">
                                    <?= formatPrice($producto['precio']) ?>
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <a href="<?= APP_URL ?>/producto/<?= $producto['id'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> Ver detalles
                                </a>

                                <?php if ($producto['stock'] > 0): ?>
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-add-to-cart"
                                        data-product-id="<?= $producto['id'] ?>"
                                        data-product-name="<?= sanitize($producto['nombre']) ?>"
                                        data-product-price="<?= $producto['precio'] ?>"
                                    >
                                        <i class="bi bi-cart-plus"></i> Agregar al carrito
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary" disabled>
                                        <i class="bi bi-x-circle"></i> No disponible
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Paginación de productos">
                <ul class="pagination justify-content-center">
                    <!-- Previous -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= APP_URL ?>/productos?page=<?= $page - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">
                            <i class="bi bi-chevron-left"></i> Anterior
                        </a>
                    </li>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i == $page || $i == 1 || $i == $totalPages || abs($i - $page) <= 2): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= APP_URL ?>/productos?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php elseif (abs($i - $page) == 3): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next -->
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= APP_URL ?>/productos?page=<?= $page + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">
                            Siguiente <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
