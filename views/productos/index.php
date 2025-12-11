<!-- Hero Section -->
<div class="catalog-hero-v2">
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    <div class="container">
        <div class="hero-content-v2 animate-on-scroll">
            <div class="hero-badge">
                <i class="bi bi-stars"></i>
                <span>Nueva Colección</span>
            </div>
            <h1 class="hero-title-v2">
                <span class="gradient-text">Descubre</span> tu estilo único
            </h1>
            <p class="hero-subtitle-v2">
                Moda contemporánea que refleja tu personalidad. Calidad premium, diseños exclusivos.
            </p>

            <!-- Stats -->
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number"><?= $totalProductos ?? 0 ?></div>
                    <div class="stat-label">Productos</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number"><i class="bi bi-truck"></i></div>
                    <div class="stat-label">Envío Gratis</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number"><i class="bi bi-shield-check"></i></div>
                    <div class="stat-label">Compra Segura</div>
                </div>
            </div>

            <!-- CTA -->
            <div class="hero-cta">
                <a href="#productos" class="btn-hero-primary">
                    <span>Explorar Colección</span>
                    <i class="bi bi-arrow-down"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-mouse"></div>
    </div>
</div>

<!-- Main Container -->
<div class="container py-5">
    <!-- Search Bar -->
    <div class="search-section mb-5 animate-on-scroll" id="search-section">
        <form method="GET" action="<?= APP_URL ?>/productos#search-section" class="modern-search-form">
            <div class="search-input-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Buscar productos, marcas, categorías..."
                    value="<?= sanitize($search ?? '') ?>"
                    autocomplete="off"
                >
                <?php if (!empty($search)): ?>
                    <a href="<?= APP_URL ?>/productos" class="clear-search" title="Limpiar búsqueda">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                <?php endif; ?>
            </div>
            <button type="submit" class="search-btn">
                Buscar
            </button>
        </form>
    </div>

    <!-- Products Grid -->
    <div id="productos"></div>
    <?php if (empty($productos)): ?>
        <div class="empty-state animate-on-scroll">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="empty-state-title">No se encontraron productos</h3>
            <p class="empty-state-text">
                <?php if (!empty($search)): ?>
                    Intenta con otra búsqueda o explora todas nuestras colecciones
                <?php else: ?>
                    Estamos trabajando en traerte los mejores productos. ¡Vuelve pronto!
                <?php endif; ?>
            </p>
            <?php if (!empty($search)): ?>
                <a href="<?= APP_URL ?>/productos" class="btn-modern-primary">
                    Ver todos los productos
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Products Grid -->
        <div class="products-grid">
            <?php foreach ($productos as $index => $producto): ?>
                <div class="product-card-modern animate-on-scroll" style="animation-delay: <?= $index * 0.05 ?>s">
                    <!-- Product Image -->
                    <div class="product-image-wrapper">
                        <a href="<?= APP_URL ?>/producto/<?= $producto['id'] ?>" class="product-image-link">
                            <img
                                src="<?= $this->productoModel->obtenerUrlImagen($producto['imagen']) ?>"
                                alt="<?= sanitize($producto['nombre']) ?>"
                                class="product-image"
                                loading="lazy"
                            >
                            <div class="product-overlay">
                                <span class="quick-view">
                                    <i class="bi bi-eye"></i> Vista rápida
                                </span>
                            </div>
                        </a>

                        <!-- Stock Badge -->
                        <?php if ($producto['stock'] <= 0): ?>
                            <span class="product-badge badge-danger">
                                <i class="bi bi-x-circle"></i> Agotado
                            </span>
                        <?php elseif ($producto['stock'] <= 5): ?>
                            <span class="product-badge badge-warning">
                                <i class="bi bi-exclamation-circle"></i> Últimas <?= $producto['stock'] ?>
                            </span>
                        <?php elseif ($producto['stock'] <= 10): ?>
                            <span class="product-badge badge-new">
                                <i class="bi bi-fire"></i> Popular
                            </span>
                        <?php endif; ?>

                        <!-- Quick Actions -->
                        <div class="product-quick-actions">
                            <button class="quick-action-btn" title="Agregar a favoritos">
                                <i class="bi bi-heart"></i>
                            </button>
                            <a href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>?text=<?= urlencode('Hola, me interesa este producto: ' . $producto['nombre']) ?>"
                               target="_blank"
                               class="quick-action-btn whatsapp-btn"
                               title="Consultar por WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?= APP_URL ?>/producto/<?= $producto['id'] ?>">
                                <?= sanitize($producto['nombre']) ?>
                            </a>
                        </h3>

                        <p class="product-description">
                            <?= sanitize(substr($producto['descripcion'], 0, 60)) ?><?= strlen($producto['descripcion']) > 60 ? '...' : '' ?>
                        </p>

                        <div class="product-footer">
                            <div class="product-price-section">
                                <span class="product-price">
                                    <?= formatPrice($producto['precio']) ?>
                                </span>
                            </div>

                            <?php if ($producto['stock'] > 0): ?>
                                <button
                                    type="button"
                                    class="btn-add-cart btn-add-to-cart"
                                    data-product-id="<?= $producto['id'] ?>"
                                    data-product-name="<?= sanitize($producto['nombre']) ?>"
                                    data-product-price="<?= $producto['precio'] ?>"
                                    title="Agregar al carrito"
                                >
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Agregar</span>
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn-add-cart btn-disabled" disabled>
                                    <i class="bi bi-x-circle"></i>
                                    <span>Agotado</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Navegación de productos" class="pagination-nav">
                <ul class="pagination-list">
                    <!-- Primera página -->
                    <?php if ($page > 1): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=1<?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link"
                               aria-label="Primera página">
                                <i class="bi bi-chevron-bar-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Página anterior -->
                    <?php if ($page > 1): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=<?= $page - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link"
                               aria-label="Página anterior">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Números de página -->
                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);

                    // Mostrar primera página si no está en rango
                    if ($startPage > 1): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=1<?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link">1</a>
                        </li>
                        <?php if ($startPage > 2): ?>
                            <li><span class="pagination-dots">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Páginas cercanas -->
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link <?= $i === $page ? 'active' : '' ?>"
                               <?= $i === $page ? 'aria-current="page"' : '' ?>>
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Mostrar última página si no está en rango -->
                    <?php if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                            <li><span class="pagination-dots">...</span></li>
                        <?php endif; ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=<?= $totalPages ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link"><?= $totalPages ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Página siguiente -->
                    <?php if ($page < $totalPages): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=<?= $page + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link"
                               aria-label="Página siguiente">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Última página -->
                    <?php if ($page < $totalPages): ?>
                        <li>
                            <a href="<?= APP_URL ?>/productos?page=<?= $totalPages ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= $categoriaId ? '&categoria=' . $categoriaId : '' ?>#productos"
                               class="pagination-link"
                               aria-label="Última página">
                                <i class="bi bi-chevron-bar-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Info de página actual -->
                <div class="pagination-info">
                    Página <?= $page ?> de <?= $totalPages ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
/* ========================================
   CATALOG HERO
   ======================================== */
.catalog-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 0 3rem;
    position: relative;
    overflow: hidden;
}

.catalog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    text-align: center;
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    font-family: var(--font-display);
    line-height: 1.1;
}

.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-weight: 300;
}

/* ========================================
   MODERN SEARCH
   ======================================== */
.search-section {
    max-width: 700px;
    margin: 0 auto;
}

.modern-search-form {
    display: flex;
    gap: 0.75rem;
    align-items: stretch;
}

.search-input-wrapper {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 1.25rem;
    color: var(--gray-400);
    font-size: 1.1rem;
    pointer-events: none;
}

.search-input {
    width: 100%;
    padding: 1rem 3rem 1rem 3.5rem;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    font-size: 1rem;
    transition: all var(--transition-base);
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
}

.clear-search {
    position: absolute;
    right: 1rem;
    color: var(--gray-400);
    font-size: 1.25rem;
    transition: color var(--transition-fast);
}

.clear-search:hover {
    color: var(--danger);
}

.search-btn {
    padding: 1rem 2rem;
    background: var(--gradient-accent);
    color: white;
    border: none;
    border-radius: var(--radius-lg);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition-base);
    white-space: nowrap;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* ========================================
   PRODUCTS GRID
   ======================================== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.product-card-modern {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.product-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.product-image-wrapper {
    position: relative;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: var(--gray-100);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.product-card-modern:hover .product-image {
    transform: scale(1.08);
}

.product-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 1.5rem;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.product-card-modern:hover .product-overlay {
    opacity: 1;
}

.quick-view {
    background: white;
    color: var(--gray-900);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Product Badges */
.product-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-md);
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    backdrop-filter: blur(10px);
    z-index: 2;
}

.badge-danger {
    background: rgba(255, 107, 107, 0.95);
    color: white;
}

.badge-warning {
    background: rgba(255, 212, 59, 0.95);
    color: var(--gray-900);
}

.badge-new {
    background: rgba(108, 92, 231, 0.95);
    color: white;
}

/* Quick Actions */
.product-quick-actions {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transform: translateX(-10px);
    transition: all var(--transition-base);
}

.product-card-modern:hover .product-quick-actions {
    opacity: 1;
    transform: translateX(0);
}

.quick-action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-md);
    color: var(--gray-700);
    text-decoration: none;
}

.quick-action-btn:hover {
    transform: scale(1.1);
    color: var(--accent);
}

.whatsapp-btn:hover {
    background: var(--whatsapp);
    color: white;
}

/* Product Info */
.product-info {
    padding: 1.25rem;
}

.product-name {
    font-size: 1.125rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.product-name a {
    color: var(--gray-900);
    text-decoration: none;
    transition: color var(--transition-base);
}

.product-name a:hover {
    color: var(--accent);
}

.product-description {
    font-size: 0.875rem;
    color: var(--gray-600);
    margin-bottom: 1rem;
    line-height: 1.5;
    min-height: 2.6em;
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.product-price {
    font-size: 1.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.btn-add-cart {
    padding: 0.65rem 1.25rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all var(--transition-base);
    white-space: nowrap;
}

.btn-add-cart:not(.btn-disabled) {
    background: var(--gradient-accent);
    color: white;
}

.btn-add-cart:not(.btn-disabled):hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-disabled {
    background: var(--gray-300);
    color: var(--gray-600);
    cursor: not-allowed;
}

/* ========================================
   EMPTY STATE
   ======================================== */
.empty-state {
    text-align: center;
    padding: 5rem 2rem;
}

.empty-state-icon {
    font-size: 5rem;
    color: var(--gray-300);
    margin-bottom: 1.5rem;
}

.empty-state-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
}

.empty-state-text {
    font-size: 1.125rem;
    color: var(--gray-600);
    margin-bottom: 2rem;
}

.btn-modern-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: var(--gradient-accent);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-lg);
    font-weight: 600;
    transition: all var(--transition-base);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: white;
}

/* ========================================
   PAGINACIÓN
   ======================================== */
.pagination-nav {
    margin-top: 3rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.pagination-list {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 0.75rem;
    border-radius: var(--radius-md);
    background: white;
    color: var(--gray-700);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.938rem;
    transition: all var(--transition-base);
    border: 2px solid var(--gray-200);
}

.pagination-link:hover {
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.pagination-link.active {
    background: var(--gradient-accent);
    color: white;
    border-color: transparent;
    box-shadow: var(--shadow-md);
}

.pagination-link.active:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.pagination-dots {
    color: var(--gray-400);
    padding: 0 0.5rem;
    font-weight: 700;
}

.pagination-info {
    color: var(--gray-600);
    font-size: 0.938rem;
    font-weight: 500;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .catalog-hero {
        padding: 3rem 0 2rem;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }

    .product-info {
        padding: 1rem;
    }

    .product-name {
        font-size: 0.938rem;
    }

    .product-price {
        font-size: 1.125rem;
    }

    .btn-add-cart span {
        display: none;
    }

    .modern-search-form {
        flex-direction: column;
    }

    .pagination-list {
        gap: 0.375rem;
    }

    .pagination-link {
        min-width: 38px;
        height: 38px;
        font-size: 0.875rem;
        padding: 0 0.5rem;
    }

    .pagination-info {
        font-size: 0.875rem;
    }
}
</style>
