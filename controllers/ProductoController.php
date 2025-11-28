<?php
/**
 * CONTROLADOR DE PRODUCTOS - KYOSHOP STORE
 *
 * Maneja la visualización del catálogo y detalles de productos
 */

require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new Producto();
    }

    /**
     * Mostrar catálogo de productos (página principal de productos)
     */
    public function index() {
        // Obtener parámetros de paginación y búsqueda
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;

        // Obtener productos según filtros
        if (!empty($search)) {
            $productos = $this->productoModel->buscar($search, $page);
            $totalProductos = count($productos); // Simplificado, idealmente contar con query
        } elseif ($categoriaId) {
            $productos = $this->productoModel->obtenerPorCategoria($categoriaId, $page);
            $totalProductos = count($productos);
        } else {
            $productos = $this->productoModel->obtenerTodos($page);
            $totalProductos = $this->productoModel->contarTotal();
        }

        // Calcular paginación
        $totalPages = ceil($totalProductos / ITEMS_PER_PAGE);

        // Preparar datos para la vista
        $pageTitle = 'Catálogo de Productos';
        $pageDescription = 'Explora nuestro catálogo completo de ropa y accesorios';

        // Renderizar vista
        $content = $this->render('productos/index', [
            'productos' => $productos,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'categoriaId' => $categoriaId
        ]);

        $this->renderLayout($content, $pageTitle, $pageDescription);
    }

    /**
     * Mostrar detalle de un producto específico
     *
     * @param int $id ID del producto
     */
    public function detalle($id) {
        // Validar ID
        if (!$id || !is_numeric($id)) {
            $this->redirect404();
            return;
        }

        // Obtener producto
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            $this->redirect404();
            return;
        }

        // Obtener productos relacionados
        $productosRelacionados = $this->productoModel->obtenerRelacionados(
            $id,
            $producto['categoria']
        );

        // Preparar datos para la vista
        $pageTitle = sanitize($producto['nombre']);
        $pageDescription = sanitize(substr($producto['descripcion'], 0, 150));

        // Renderizar vista
        $content = $this->render('productos/detalle', [
            'producto' => $producto,
            'productosRelacionados' => $productosRelacionados
        ]);

        $this->renderLayout($content, $pageTitle, $pageDescription);
    }

    /**
     * Renderizar una vista
     *
     * @param string $view Ruta de la vista (ej: 'productos/index')
     * @param array $data Datos a pasar a la vista
     * @return string Contenido renderizado
     */
    private function render($view, $data = []) {
        // Extraer variables para la vista
        extract($data);

        // Buffer de salida
        ob_start();

        // Incluir vista
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<div class='container'><div class='alert alert-danger'>Vista no encontrada: {$view}</div></div>";
        }

        return ob_get_clean();
    }

    /**
     * Renderizar con layout
     *
     * @param string $content Contenido principal
     * @param string $pageTitle Título de la página
     * @param string $pageDescription Descripción para SEO
     */
    private function renderLayout($content, $pageTitle = 'KyoShop', $pageDescription = '') {
        include __DIR__ . '/../views/layouts/public.php';
    }

    /**
     * Redirigir a página 404
     */
    private function redirect404() {
        http_response_code(404);

        $pageTitle = 'Producto no encontrado';
        $content = $this->render('errors/404', [
            'message' => 'El producto que buscas no existe o no está disponible.'
        ]);

        $this->renderLayout($content, $pageTitle);
    }
}
?>
