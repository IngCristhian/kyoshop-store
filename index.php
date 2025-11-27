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

// Obtener la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($script_name, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Routing simple (expandir según necesidades)
switch(true) {
    case empty($path):
    case $path === '/':
        // Homepage
        echo '<h1>KyoShop - Tienda Online</h1>';
        echo '<p>🚧 En construcción...</p>';
        echo '<p>Sistema administrativo: <a href="' . ADMIN_URL . '">' . ADMIN_URL . '</a></p>';
        break;

    case preg_match('/^productos$/', $path):
        // Catálogo de productos
        echo '<h1>Catálogo</h1>';
        echo '<p>Próximamente: Grid de productos</p>';
        break;

    case preg_match('/^producto\/(\d+)$/', $path, $matches):
        // Detalle de producto
        $productId = $matches[1];
        echo '<h1>Producto #' . $productId . '</h1>';
        echo '<p>Próximamente: Detalle del producto</p>';
        break;

    case $path === 'carrito':
        // Carrito de compras
        echo '<h1>Carrito</h1>';
        echo '<p>Próximamente: Carrito de compras</p>';
        break;

    case $path === 'checkout':
        // Checkout
        echo '<h1>Checkout</h1>';
        echo '<p>Próximamente: Proceso de pago</p>';
        break;

    default:
        // 404
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        echo '<a href="' . APP_URL . '">Volver al inicio</a>';
        break;
}

// TODO: Implementar controladores y vistas reales
// TODO: Cargar modelos necesarios
// TODO: Implementar sistema de templates
?>
