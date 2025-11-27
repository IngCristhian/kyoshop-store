<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageDescription ?? 'KyoShop - Tienda de ropa online' ?>">
    <title><?= $pageTitle ?? 'KyoShop' ?> | KyoShop</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/store.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= APP_URL ?>/assets/img/favicon.ico">
</head>
<body>
    <!-- Header / Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= APP_URL ?>">
                <i class="bi bi-shop text-primary"></i> KyoShop
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_URL ?>">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_URL ?>/productos">
                            <i class="bi bi-grid"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="<?= APP_URL ?>/carrito">
                            <i class="bi bi-cart3"></i> Carrito
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                                0
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>?text=Hola%2C%20tengo%20una%20consulta" target="_blank">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= sanitize($_SESSION['success_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= sanitize($_SESSION['error_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="bi bi-shop"></i> KyoShop</h5>
                    <p class="text-muted">Tu tienda de ropa favorita</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Enlaces</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= APP_URL ?>/productos" class="text-muted text-decoration-none">Productos</a></li>
                        <li><a href="<?= APP_URL ?>/carrito" class="text-muted text-decoration-none">Carrito</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Políticas de privacidad</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Términos y condiciones</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contacto</h6>
                    <ul class="list-unstyled text-muted">
                        <li><i class="bi bi-whatsapp"></i> WhatsApp: <?= WHATSAPP_NUMBER ?></li>
                        <li><i class="bi bi-envelope"></i> <?= EMAIL_FROM ?></li>
                        <li><i class="bi bi-geo-alt"></i> Medellín, Colombia</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; <?= date('Y') ?> KyoShop. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= APP_URL ?>/assets/js/store.js"></script>
</body>
</html>
