<div class="container py-4">
    <!-- Modern Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="modern-breadcrumb">
            <li><a href="<?= APP_URL ?>"><i class="bi bi-house-door"></i> Inicio</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li><a href="<?= APP_URL ?>/productos">Productos</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="active"><?= sanitize($producto['nombre']) ?></li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="product-detail-container">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-detail-image animate-on-scroll">
                    <div class="image-wrapper">
                        <img
                            src="<?= $this->productoModel->obtenerUrlImagen($producto['imagen']) ?>"
                            alt="<?= sanitize($producto['nombre']) ?>"
                            class="main-product-image"
                            id="mainImage"
                        >

                        <!-- Stock Badge -->
                        <?php if ($producto['stock'] <= 0): ?>
                            <span class="detail-badge badge-sold-out">
                                <i class="bi bi-x-circle"></i> Agotado
                            </span>
                        <?php elseif ($producto['stock'] <= 5): ?>
                            <span class="detail-badge badge-limited">
                                <i class="bi bi-fire"></i> Solo quedan <?= $producto['stock'] ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Image Actions -->
                    <div class="image-actions">
                        <button class="image-action-btn" title="Ampliar imagen">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                        <button class="image-action-btn" title="Compartir">
                            <i class="bi bi-share"></i>
                        </button>
                        <button class="image-action-btn" title="Agregar a favoritos">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-detail-info animate-on-scroll">
                    <!-- Product Title -->
                    <h1 class="product-detail-title"><?= sanitize($producto['nombre']) ?></h1>

                    <!-- Product Code -->
                    <p class="product-code">
                        <i class="bi bi-upc"></i> SKU: <?= sanitize($producto['codigo_producto']) ?>
                    </p>

                    <!-- Product Attributes -->
                    <?php if (!empty($producto['talla']) || !empty($producto['color'])): ?>
                        <div class="product-attributes">
                            <?php if (!empty($producto['talla'])): ?>
                                <span class="attribute-badge">
                                    <i class="bi bi-rulers"></i>
                                    <strong>Talla:</strong> <?= sanitize($producto['talla']) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($producto['color'])): ?>
                                <span class="attribute-badge">
                                    <i class="bi bi-palette"></i>
                                    <strong>Color:</strong> <?= sanitize($producto['color']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Price Section -->
                    <div class="price-section">
                        <div class="price-main">
                            <span class="price-label">Precio:</span>
                            <span class="price-value"><?= formatPrice($producto['precio']) ?></span>
                        </div>

                        <!-- Stock Indicator -->
                        <div class="stock-indicator">
                            <?php if ($producto['stock'] > 0): ?>
                                <div class="stock-available">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span><?= $producto['stock'] ?> disponibles</span>
                                </div>
                            <?php else: ?>
                                <div class="stock-unavailable">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span>Agotado</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="product-description">
                        <h3 class="section-title">Descripción</h3>
                        <p><?= nl2br(sanitize($producto['descripcion'])) ?></p>
                    </div>

                    <!-- Purchase Section -->
                    <div class="purchase-section">
                        <?php if ($producto['stock'] > 0): ?>
                            <!-- Quantity Selector -->
                            <div class="quantity-selector">
                                <label class="quantity-label">Cantidad:</label>
                                <div class="quantity-controls">
                                    <button class="qty-btn" onclick="decrementQty()">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input
                                        type="number"
                                        id="cantidad"
                                        class="qty-input"
                                        value="1"
                                        min="1"
                                        max="<?= $producto['stock'] ?>"
                                        readonly
                                    >
                                    <button class="qty-btn" onclick="incrementQty(<?= $producto['stock'] ?>)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button
                                    type="button"
                                    class="btn-detail-primary btn-add-to-cart"
                                    data-product-id="<?= $producto['id'] ?>"
                                    data-product-name="<?= sanitize($producto['nombre']) ?>"
                                    data-product-price="<?= $producto['precio'] ?>"
                                >
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Agregar al carrito</span>
                                </button>

                                <button
                                    type="button"
                                    class="btn-detail-whatsapp"
                                    onclick="comprarPorWhatsApp(<?= htmlspecialchars(json_encode($producto), ENT_QUOTES, 'UTF-8') ?>)"
                                >
                                    <i class="bi bi-whatsapp"></i>
                                    <span>Comprar por WhatsApp</span>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="unavailable-section">
                                <p class="unavailable-text">Este producto está agotado</p>
                                <a
                                    href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>?text=<?= urlencode("Hola, me interesa el producto: " . $producto['nombre'] . " (Código: " . $producto['codigo_producto'] . "). ¿Cuándo estará disponible?") ?>"
                                    target="_blank"
                                    class="btn-detail-whatsapp"
                                >
                                    <i class="bi bi-whatsapp"></i>
                                    <span>Consultar disponibilidad</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Shipping Info -->
                    <div class="shipping-info">
                        <h4 class="info-title">
                            <i class="bi bi-truck"></i> Información de envío
                        </h4>
                        <ul class="info-list">
                            <li>
                                <i class="bi bi-check2"></i>
                                <span>Envío gratis en compras superiores a <strong><?= formatPrice(FREE_SHIPPING_THRESHOLD) ?></strong></span>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <span>Medellín: <?= formatPrice(SHIPPING_COST_MEDELLIN) ?></span>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <span>Bogotá: <?= formatPrice(SHIPPING_COST_BOGOTA) ?></span>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <span>Otras ciudades: $16.000 - $20.000</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Features -->
                    <div class="product-features">
                        <div class="feature-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Compra segura</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-arrow-return-left"></i>
                            <span>Devolución fácil</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-chat-dots"></i>
                            <span>Soporte 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($productosRelacionados)): ?>
        <div class="related-products-section">
            <h2 class="section-main-title">También te puede interesar</h2>

            <div class="related-products-grid">
                <?php foreach ($productosRelacionados as $related): ?>
                    <div class="related-product-card animate-on-scroll">
                        <a href="<?= APP_URL ?>/producto/<?= $related['id'] ?>" class="related-image-link">
                            <img
                                src="<?= $this->productoModel->obtenerUrlImagen($related['imagen']) ?>"
                                alt="<?= sanitize($related['nombre']) ?>"
                                class="related-product-image"
                                loading="lazy"
                            >
                        </a>
                        <div class="related-product-info">
                            <h4 class="related-product-name">
                                <a href="<?= APP_URL ?>/producto/<?= $related['id'] ?>">
                                    <?= sanitize($related['nombre']) ?>
                                </a>
                            </h4>
                            <p class="related-product-price">
                                <?= formatPrice($related['precio']) ?>
                            </p>
                            <a href="<?= APP_URL ?>/producto/<?= $related['id'] ?>" class="btn-related">
                                Ver producto
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Quantity Controls
function incrementQty(max) {
    const input = document.getElementById('cantidad');
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('cantidad');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}

// WhatsApp Purchase
function comprarPorWhatsApp(producto) {
    const cantidad = document.getElementById('cantidad').value || 1;
    const whatsappNumber = '<?= str_replace('+', '', WHATSAPP_NUMBER) ?>';
    const total = producto.precio * cantidad;

    const mensaje = `Hola, me interesa este producto:

📦 *${producto.nombre}*
🔢 Código: ${producto.codigo_producto}
💵 Precio unitario: ${formatPriceJS(producto.precio)}
📊 Cantidad: ${cantidad}
💰 Total: ${formatPriceJS(total)}

¿Está disponible?`;

    const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
}

function formatPriceJS(price) {
    return '$' + new Intl.NumberFormat('es-CO').format(price);
}
</script>

<style>
/* ========================================
   MODERN BREADCRUMB
   ======================================== */
.modern-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.875rem;
}

.modern-breadcrumb li {
    display: flex;
    align-items: center;
}

.modern-breadcrumb a {
    color: var(--gray-600);
    text-decoration: none;
    transition: color var(--transition-base);
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.modern-breadcrumb a:hover {
    color: var(--accent);
}

.modern-breadcrumb .active {
    color: var(--gray-900);
    font-weight: 600;
}

.modern-breadcrumb .bi-chevron-right {
    font-size: 0.75rem;
    color: var(--gray-400);
}

/* ========================================
   PRODUCT DETAIL IMAGE
   ======================================== */
.product-detail-image {
    position: relative;
}

.image-wrapper {
    position: relative;
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.main-product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform var(--transition-slow);
}

.image-wrapper:hover .main-product-image {
    transform: scale(1.05);
}

.detail-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-lg);
    font-weight: 700;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    z-index: 2;
}

.badge-sold-out {
    background: rgba(255, 107, 107, 0.95);
    color: white;
}

.badge-limited {
    background: rgba(255, 212, 59, 0.95);
    color: var(--gray-900);
}

.image-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.image-action-btn {
    flex: 1;
    padding: 0.875rem;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    color: var(--gray-700);
    cursor: pointer;
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-weight: 600;
}

.image-action-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-2px);
}

/* ========================================
   PRODUCT DETAIL INFO
   ======================================== */
.product-detail-title {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
    line-height: 1.2;
}

.product-code {
    color: var(--gray-500);
    font-size: 0.875rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Product Attributes */
.product-attributes {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.attribute-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    font-size: 0.938rem;
    color: var(--gray-700);
    font-weight: 500;
}

.attribute-badge i {
    color: var(--accent);
    font-size: 1rem;
}

.attribute-badge strong {
    font-weight: 700;
}

.price-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
}

.price-main {
    display: flex;
    align-items: baseline;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.price-label {
    font-size: 1rem;
    color: var(--gray-600);
    font-weight: 500;
}

.price-value {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stock-indicator {
    display: flex;
    align-items: center;
}

.stock-available {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--success);
    font-weight: 600;
}

.stock-unavailable {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--danger);
    font-weight: 600;
}

.product-description {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
}

.product-description p {
    color: var(--gray-700);
    line-height: 1.7;
}

/* ========================================
   PURCHASE SECTION
   ======================================== */
.purchase-section {
    margin-bottom: 2rem;
}

.quantity-selector {
    margin-bottom: 1.5rem;
}

.quantity-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--gray-700);
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0;
    width: fit-content;
}

.qty-btn {
    width: 44px;
    height: 44px;
    background: white;
    border: 2px solid var(--gray-200);
    color: var(--gray-700);
    cursor: pointer;
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
}

.qty-btn:first-child {
    border-radius: var(--radius-md) 0 0 var(--radius-md);
}

.qty-btn:last-child {
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
}

.qty-btn:hover {
    background: var(--gray-100);
    border-color: var(--accent);
    color: var(--accent);
}

.qty-input {
    width: 80px;
    height: 44px;
    text-align: center;
    border: 2px solid var(--gray-200);
    border-left: none;
    border-right: none;
    font-weight: 700;
    font-size: 1.125rem;
    color: var(--gray-900);
}

.action-buttons {
    display: grid;
    gap: 1rem;
}

.btn-detail-primary,
.btn-detail-whatsapp {
    padding: 1rem 2rem;
    border-radius: var(--radius-lg);
    font-weight: 700;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    border: none;
    cursor: pointer;
    transition: all var(--transition-base);
    text-decoration: none;
}

.btn-detail-primary {
    background: var(--gradient-accent);
    color: white;
}

.btn-detail-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-detail-whatsapp {
    background: var(--whatsapp);
    color: white;
}

.btn-detail-whatsapp:hover {
    background: #1ebc59;
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.unavailable-section {
    text-align: center;
    padding: 2rem;
    background: var(--gray-100);
    border-radius: var(--radius-lg);
}

.unavailable-text {
    font-size: 1.125rem;
    color: var(--gray-700);
    margin-bottom: 1.5rem;
}

/* ========================================
   SHIPPING INFO
   ======================================== */
.shipping-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    margin-bottom: 1.5rem;
}

.info-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.5rem 0;
    color: var(--gray-700);
}

.info-list li i {
    color: var(--accent);
    margin-top: 0.25rem;
}

/* ========================================
   PRODUCT FEATURES
   ======================================== */
.product-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
}

.feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    text-align: center;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-700);
    transition: all var(--transition-base);
}

.feature-item i {
    font-size: 1.5rem;
    color: var(--accent);
}

.feature-item:hover {
    border-color: var(--accent);
    transform: translateY(-2px);
}

/* ========================================
   RELATED PRODUCTS
   ======================================== */
.related-products-section {
    margin-top: 5rem;
    padding-top: 3rem;
    border-top: 2px solid var(--gray-200);
}

.section-main-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 2rem;
    text-align: center;
}

.related-products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
}

.related-product-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-base);
}

.related-product-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.related-image-link {
    display: block;
    aspect-ratio: 3/4;
    overflow: hidden;
}

.related-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.related-product-card:hover .related-product-image {
    transform: scale(1.05);
}

.related-product-info {
    padding: 1.25rem;
}

.related-product-name {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.related-product-name a {
    color: var(--gray-900);
    text-decoration: none;
    transition: color var(--transition-base);
}

.related-product-name a:hover {
    color: var(--accent);
}

.related-product-price {
    font-size: 1.25rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.btn-related {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    color: var(--gray-700);
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    transition: all var(--transition-base);
}

.btn-related:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: var(--gray-50);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .product-detail-title {
        font-size: 1.75rem;
    }

    .price-value {
        font-size: 2rem;
    }

    .image-actions {
        grid-template-columns: 1fr 1fr;
    }

    .product-features {
        grid-template-columns: 1fr;
    }

    .related-products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}
</style>
