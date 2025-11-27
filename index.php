<?php
/**
 * KYOSHOP STORE - FRONT CONTROLLER
 * Entry point para la tienda online
 *
 * Parte del ecosistema KyoShop
 * Admin System: https://github.com/IngCristhian/kyoshop-inventory
 */

// Configurar errores (cambiar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar configuraciones
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// Cargar controladores
require_once __DIR__ . '/controllers/ProductoController.php';

// Obtener la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($script_name, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Routing
switch(true) {
    case empty($path):
    case $path === '/':
        // Homepage - redirigir a productos por ahora
        header('Location: ' . APP_URL . '/productos');
        exit;

    case preg_match('/^productos$/', $path):
        // Catálogo de productos
        $controller = new ProductoController();
        $controller->index();
        break;

    case preg_match('/^producto\/(\d+)$/', $path, $matches):
        // Detalle de producto
        $productId = (int)$matches[1];
        $controller = new ProductoController();
        $controller->detalle($productId);
        break;

    case $path === 'carrito':
        // Carrito de compras (próximamente)
        echo '<h1>Carrito</h1>';
        echo '<p>Próximamente: Carrito de compras</p>';
        break;

    case $path === 'checkout':
        // Checkout (próximamente)
        echo '<h1>Checkout</h1>';
        echo '<p>Próximamente: Proceso de pago</p>';
        break;

    default:
        // 404
        http_response_code(404);
        require_once __DIR__ . '/controllers/ProductoController.php';
        $controller = new ProductoController();
        $pageTitle = 'Página no encontrada';
        $content = (function() {
            ob_start();
            include __DIR__ . '/views/errors/404.php';
            return ob_get_clean();
        })();
        include __DIR__ . '/views/layouts/public.php';
        break;
}
?>
