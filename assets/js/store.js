/**
 * KYOSHOP STORE - CUSTOM JAVASCRIPT
 * Funcionalidad del lado del cliente para la tienda online
 */

// Estado del carrito (localStorage)
const Cart = {
    STORAGE_KEY: 'kyoshop_cart',

    /**
     * Obtener carrito del localStorage
     */
    get() {
        try {
            const cart = localStorage.getItem(this.STORAGE_KEY);
            return cart ? JSON.parse(cart) : [];
        } catch (error) {
            console.error('Error al obtener carrito:', error);
            return [];
        }
    },

    /**
     * Guardar carrito en localStorage
     */
    save(cart) {
        try {
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(cart));
            this.updateCount();
        } catch (error) {
            console.error('Error al guardar carrito:', error);
        }
    },

    /**
     * Agregar producto al carrito
     */
    add(productId, productName, productPrice, quantity = 1) {
        const cart = this.get();
        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: quantity
            });
        }

        this.save(cart);
        return true;
    },

    /**
     * Eliminar producto del carrito
     */
    remove(productId) {
        let cart = this.get();
        cart = cart.filter(item => item.id !== productId);
        this.save(cart);
    },

    /**
     * Actualizar cantidad de un producto
     */
    updateQuantity(productId, quantity) {
        const cart = this.get();
        const item = cart.find(item => item.id === productId);

        if (item) {
            item.quantity = quantity;
            this.save(cart);
        }
    },

    /**
     * Limpiar carrito
     */
    clear() {
        localStorage.removeItem(this.STORAGE_KEY);
        this.updateCount();
    },

    /**
     * Obtener total de items en el carrito
     */
    getCount() {
        const cart = this.get();
        return cart.reduce((total, item) => total + item.quantity, 0);
    },

    /**
     * Actualizar contador visual del carrito
     */
    updateCount() {
        const count = this.getCount();
        const badge = document.getElementById('cart-count');

        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    },

    /**
     * Obtener total del carrito
     */
    getTotal() {
        const cart = this.get();
        return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }
};

/**
 * Mostrar notificación toast
 */
function showToast(message, type = 'success') {
    // Crear elemento de alerta si no existe
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto-remover después de 3 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

/**
 * Formatear precio en pesos colombianos
 */
function formatPrice(price) {
    return '$' + new Intl.NumberFormat('es-CO').format(price);
}

/**
 * Inicialización cuando el DOM está listo
 */
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar contador del carrito
    Cart.updateCount();

    // Manejar clicks en botones "Agregar al carrito"
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = parseInt(this.dataset.productId);
            const productName = this.dataset.productName;
            const productPrice = parseFloat(this.dataset.productPrice);

            // Obtener cantidad si existe input
            let quantity = 1;
            const quantityInput = document.getElementById('cantidad');
            if (quantityInput) {
                quantity = parseInt(quantityInput.value) || 1;
            }

            // Agregar al carrito
            const success = Cart.add(productId, productName, productPrice, quantity);

            if (success) {
                // Mostrar feedback visual
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-circle"></i> Agregado';
                this.disabled = true;

                // Mostrar toast
                showToast(`${productName} agregado al carrito`, 'success');

                // Restaurar botón después de 1 segundo
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            } else {
                showToast('Error al agregar al carrito', 'danger');
            }
        });
    });

    // Manejar formulario de búsqueda
    const searchForm = document.querySelector('form[action*="productos"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            if (searchInput && !searchInput.value.trim()) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }

    // Lazy loading de imágenes (si no es soportado nativamente)
    if ('loading' in HTMLImageElement.prototype === false) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src || img.src;
        });
    }
});

/**
 * Validar cantidad en inputs numéricos
 */
document.addEventListener('input', function(e) {
    if (e.target.type === 'number') {
        const min = parseInt(e.target.min) || 1;
        const max = parseInt(e.target.max) || Infinity;
        let value = parseInt(e.target.value);

        if (value < min) {
            e.target.value = min;
        } else if (value > max) {
            e.target.value = max;
        }
    }
});

/**
 * Confirmar acciones destructivas
 */
function confirmAction(message) {
    return confirm(message || '¿Estás seguro de realizar esta acción?');
}

/**
 * Scroll suave a un elemento
 */
function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Exportar funciones globales
window.Cart = Cart;
window.showToast = showToast;
window.formatPrice = formatPrice;
window.confirmAction = confirmAction;
window.scrollToElement = scrollToElement;
