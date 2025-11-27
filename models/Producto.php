<?php
/**
 * MODELO PRODUCTO - KYOSHOP STORE
 *
 * ⚠️ READ-ONLY: Este modelo SOLO lee de la tabla productos
 * La tabla es compartida con el sistema admin (inventory)
 * NO se pueden modificar productos, stock o precios desde aquí
 */

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Obtener todos los productos activos (paginados)
     *
     * @param int $page Número de página
     * @param int $perPage Productos por página
     * @return array Lista de productos
     */
    public function obtenerTodos($page = 1, $perPage = ITEMS_PER_PAGE) {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT
                    id,
                    codigo,
                    nombre,
                    descripcion,
                    precio,
                    stock,
                    imagen,
                    categoria_id,
                    activo,
                    fecha_creacion
                FROM productos
                WHERE activo = 1
                ORDER BY fecha_creacion DESC
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en obtenerTodos(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener un producto por ID
     *
     * @param int $id ID del producto
     * @return array|false Producto o false si no existe
     */
    public function obtenerPorId($id) {
        $sql = "SELECT
                    id,
                    codigo,
                    nombre,
                    descripcion,
                    precio,
                    stock,
                    imagen,
                    categoria_id,
                    activo,
                    fecha_creacion
                FROM productos
                WHERE id = :id AND activo = 1";

        try {
            return $this->db->fetch($sql, ['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Buscar productos por nombre o descripción
     *
     * @param string $termino Término de búsqueda
     * @param int $page Número de página
     * @param int $perPage Productos por página
     * @return array Lista de productos
     */
    public function buscar($termino, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT
                    id,
                    codigo,
                    nombre,
                    descripcion,
                    precio,
                    stock,
                    imagen,
                    categoria_id,
                    activo,
                    fecha_creacion
                FROM productos
                WHERE activo = 1
                  AND (nombre LIKE :termino OR descripcion LIKE :termino)
                ORDER BY fecha_creacion DESC
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':termino', "%{$termino}%", PDO::PARAM_STR);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en buscar(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener productos por categoría
     *
     * @param int $categoriaId ID de la categoría
     * @param int $page Número de página
     * @param int $perPage Productos por página
     * @return array Lista de productos
     */
    public function obtenerPorCategoria($categoriaId, $page = 1, $perPage = ITEMS_PER_PAGE) {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT
                    id,
                    codigo,
                    nombre,
                    descripcion,
                    precio,
                    stock,
                    imagen,
                    categoria_id,
                    activo,
                    fecha_creacion
                FROM productos
                WHERE activo = 1
                  AND categoria_id = :categoria_id
                ORDER BY fecha_creacion DESC
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en obtenerPorCategoria(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Contar total de productos activos
     *
     * @return int Total de productos
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM productos WHERE activo = 1";

        try {
            $result = $this->db->fetch($sql);
            return (int)$result['total'];
        } catch (PDOException $e) {
            error_log("Error en contarTotal(): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Verificar si un producto tiene stock disponible
     *
     * @param int $id ID del producto
     * @param int $cantidad Cantidad solicitada
     * @return bool True si hay stock suficiente
     */
    public function tieneStock($id, $cantidad = 1) {
        $sql = "SELECT stock FROM productos WHERE id = :id AND activo = 1";

        try {
            $producto = $this->db->fetch($sql, ['id' => $id]);

            if (!$producto) {
                return false;
            }

            return (int)$producto['stock'] >= $cantidad;
        } catch (PDOException $e) {
            error_log("Error en tieneStock(): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener productos relacionados (misma categoría)
     *
     * @param int $productoId ID del producto actual
     * @param int $categoriaId ID de la categoría
     * @param int $limit Cantidad de productos a obtener
     * @return array Lista de productos relacionados
     */
    public function obtenerRelacionados($productoId, $categoriaId, $limit = 4) {
        $sql = "SELECT
                    id,
                    codigo,
                    nombre,
                    descripcion,
                    precio,
                    stock,
                    imagen,
                    categoria_id
                FROM productos
                WHERE activo = 1
                  AND categoria_id = :categoria_id
                  AND id != :producto_id
                ORDER BY RAND()
                LIMIT :limit";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
            $stmt->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en obtenerRelacionados(): " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener URL de la imagen del producto
     *
     * @param string|null $imagen Nombre de la imagen
     * @return string URL de la imagen o placeholder
     */
    public function obtenerUrlImagen($imagen) {
        if (empty($imagen)) {
            return APP_URL . '/assets/img/producto-placeholder.jpg';
        }

        // Asumiendo que las imágenes están en /uploads/productos/
        $rutaImagen = APP_URL . '/uploads/productos/' . $imagen;

        return $rutaImagen;
    }
}
?>
