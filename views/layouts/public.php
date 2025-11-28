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

    <!-- Google Fonts - Inter & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/store.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= APP_URL ?>/assets/img/favicon.png">
</head>
<body class="modern-store">
    <!-- Modern Navbar with Blur Effect -->
    <nav class="modern-nav sticky-top">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Logo -->
                <a class="brand-logo" href="<?= APP_URL ?>">
                    <img src="<?= APP_URL ?>/assets/img/logo.png" alt="KyoShop" class="logo-image">
                    <span class="brand-name">KyoShop</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="mobile-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Nav Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav-menu">
                        <li><a href="<?= APP_URL ?>" class="nav-link-modern">Inicio</a></li>
                        <li><a href="<?= APP_URL ?>/productos" class="nav-link-modern active">Productos</a></li>
                        <li><a href="#" class="nav-link-modern">Novedades</a></li>
                    </ul>

                    <!-- Nav Actions -->
                    <div class="nav-actions">
                        <a href="<?= APP_URL ?>/carrito" class="nav-icon-btn cart-btn">
                            <i class="bi bi-bag"></i>
                            <span class="cart-badge" id="cart-count">0</span>
                        </a>
                        <a href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>?text=Hola%2C%20tengo%20una%20consulta" target="_blank" class="nav-icon-btn whatsapp-btn">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <button class="nav-icon-btn">
                            <i class="bi bi-person"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="container">
                <div class="modern-alert alert-success fade-in-up">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= sanitize($_SESSION['success_message']) ?></span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="container">
                <div class="modern-alert alert-danger fade-in-up">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= sanitize($_SESSION['error_message']) ?></span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row g-4">
                    <!-- Brand Column -->
                    <div class="col-lg-4">
                        <div class="footer-brand">
                            <div class="brand-logo mb-3">
                                <img src="<?= APP_URL ?>/assets/img/logo.png" alt="KyoShop" class="logo-image">
                                <span class="brand-name">KyoShop</span>
                            </div>
                            <p class="footer-desc">
                                Tu destino para moda contemporánea. Calidad excepcional, estilo incomparable.
                            </p>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                                <a href="https://wa.me/<?= str_replace('+', '', WHATSAPP_NUMBER) ?>" target="_blank" class="social-link"><i class="bi bi-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-4 col-6">
                        <h6 class="footer-title">Comprar</h6>
                        <ul class="footer-links">
                            <li><a href="<?= APP_URL ?>/productos">Todos los productos</a></li>
                            <li><a href="#">Nuevos lanzamientos</a></li>
                            <li><a href="#">Ofertas</a></li>
                            <li><a href="#">Categorías</a></li>
                        </ul>
                    </div>

                    <!-- Help -->
                    <div class="col-lg-2 col-md-4 col-6">
                        <h6 class="footer-title">Ayuda</h6>
                        <ul class="footer-links">
                            <li><a href="#">Preguntas frecuentes</a></li>
                            <li><a href="#">Envíos</a></li>
                            <li><a href="#">Devoluciones</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="col-lg-4 col-md-4">
                        <h6 class="footer-title">Contacto</h6>
                        <ul class="footer-contact">
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <span>Medellín, Colombia</span>
                            </li>
                            <li>
                                <i class="bi bi-envelope"></i>
                                <span><?= EMAIL_FROM ?></span>
                            </li>
                            <li>
                                <i class="bi bi-whatsapp"></i>
                                <span><?= WHATSAPP_NUMBER ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">
                        &copy; <?= date('Y') ?> KyoShop. Todos los derechos reservados.
                    </p>
                    <div class="footer-bottom-links">
                        <a href="#">Términos</a>
                        <a href="#">Privacidad</a>
                        <a href="#">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= APP_URL ?>/assets/js/store.js"></script>

    <!-- Smooth Scroll & Animations -->
    <script>
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            // Observe elements for animation
            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

            // Update nav on scroll
            let lastScroll = 0;
            const nav = document.querySelector('.modern-nav');

            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll <= 0) {
                    nav.classList.remove('scrolled');
                    return;
                }

                nav.classList.add('scrolled');

                lastScroll = currentScroll;
            });
        });
    </script>
</body>
</html>
