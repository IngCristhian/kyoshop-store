<?php
/**
 * CONFIGURACIÓN GLOBAL - KYOSHOP STORE
 * Configuraciones generales de la aplicación
 */

// URL base de la aplicación (desde variable de entorno)
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8001');

// URL del sistema admin (para referencias y carga de imágenes)
define('ADMIN_URL', getenv('ADMIN_URL') ?: 'https://inventory.kyoshop.co');

// URL de imágenes (apunta al sistema de inventario donde están almacenadas)
define('IMAGES_URL', ADMIN_URL . '/uploads');

// Configuración de sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Solo en HTTPS
session_start();

// Zona horaria
date_default_timezone_set('America/Bogota');

// Paginación
define('ITEMS_PER_PAGE', 12);

// WhatsApp
define('WHATSAPP_NUMBER', getenv('WHATSAPP_NUMBER') ?: '+573001234567');

// ePayco Configuration
define('EPAYCO_PUBLIC_KEY', getenv('EPAYCO_PUBLIC_KEY') ?: '');
define('EPAYCO_PRIVATE_KEY', getenv('EPAYCO_PRIVATE_KEY') ?: '');
define('EPAYCO_TEST_MODE', getenv('EPAYCO_TEST_MODE') === 'true');

// Configuración de imágenes
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Configuración de email (opcional)
define('SMTP_HOST', getenv('SMTP_HOST') ?: '');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: '');
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: 'tienda@kyoshop.co');
define('EMAIL_FROM_NAME', 'KyoShop');

// Configuración de carrito
define('CART_SESSION_KEY', 'kyoshop_cart');
define('CART_EXPIRATION_DAYS', 7);

// Impuestos (IVA Colombia)
define('TAX_RATE', 0.19); // 19%

// Costos de envío (puede ser dinámico después)
define('SHIPPING_COST_MEDELLIN', 16000); // $16.000 COP
define('SHIPPING_COST_BOGOTA', 10000);   // $10.000 COP
define('SHIPPING_COST_OTHER', 16000);    // $16.000 - $20.000 COP (base: $16.000)
define('FREE_SHIPPING_THRESHOLD', 150000); // Envío gratis sobre $150.000

// Estados de pedidos
define('ORDER_STATUS_PENDING', 'pending');
define('ORDER_STATUS_CONFIRMED', 'confirmed');
define('ORDER_STATUS_PROCESSING', 'processing');
define('ORDER_STATUS_SHIPPED', 'shipped');
define('ORDER_STATUS_DELIVERED', 'delivered');
define('ORDER_STATUS_CANCELLED', 'cancelled');

// Métodos de pago
define('PAYMENT_METHOD_EPAYCO', 'epayco');
define('PAYMENT_METHOD_CASH', 'cash');
define('PAYMENT_METHOD_TRANSFER', 'transfer');

/**
 * Helper: Formatear precio en pesos colombianos
 */
function formatPrice($price) {
    return '$' . number_format($price, 0, ',', '.');
}

/**
 * Helper: Sanitizar output HTML
 */
function sanitize($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Helper: Generar token CSRF
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Helper: Verificar token CSRF
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Helper: Validar imagen
 */
function validateImage($file) {
    $errors = [];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Error al subir el archivo';
        return $errors;
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = 'El archivo es demasiado grande (máximo 5MB)';
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ALLOWED_EXTENSIONS)) {
        $errors[] = 'Formato de archivo no permitido';
    }

    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        $errors[] = 'El archivo no es una imagen válida';
    }

    return $errors;
}

/**
 * Helper: Calcular total con impuestos
 */
function calculateTotal($subtotal, $includeTax = true) {
    if ($includeTax) {
        return $subtotal * (1 + TAX_RATE);
    }
    return $subtotal;
}

/**
 * Helper: Calcular costo de envío
 */
function calculateShipping($city, $subtotal) {
    // Envío gratis si supera el umbral
    if ($subtotal >= FREE_SHIPPING_THRESHOLD) {
        return 0;
    }

    $city = strtolower(trim($city));

    if (strpos($city, 'medellín') !== false || strpos($city, 'medellin') !== false) {
        return SHIPPING_COST_MEDELLIN;
    } elseif (strpos($city, 'bogotá') !== false || strpos($city, 'bogota') !== false) {
        return SHIPPING_COST_BOGOTA;
    } else {
        return SHIPPING_COST_OTHER;
    }
}

/**
 * Helper: Redirect helper
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Helper: JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
