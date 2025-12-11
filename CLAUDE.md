# CLAUDE.md - KyoShop Online Store

**⚠️ IMPORTANTE: Este es uno de dos repositorios del mismo proyecto KyoShop**

## Proyectos Relacionados

Este proyecto es parte del ecosistema KyoShop que consta de:

1. **kyoshop-inventory** (Sistema Administrativo)
   - Repository: https://github.com/IngCristhian/kyoshop-inventory
   - Domain: https://inventory.kyoshop.co
   - Purpose: Sistema interno de gestión de inventario, ventas, clientes
   - Database: kyosankk_inventory (FULL ACCESS - Read/Write)

2. **kyoshop-store** (Tienda Online) ← **ESTE REPOSITORIO**
   - Repository: https://github.com/IngCristhian/kyoshop-store
   - Domain: https://kyoshop.co
   - Purpose: Tienda pública online para clientes
   - Database: kyosankk_inventory (READ-ONLY - Solo lectura)

## Project Overview

**KyoShop Online Store** - Tienda online (ecommerce) para venta de ropa al público. Desarrollado en PHP puro con JavaScript vanilla. Diseñado para ser fácil de desplegar en hosting compartido cPanel.

### Tech Stack
- **Backend**: PHP 8.2+ (sin frameworks, MVC simple)
- **Frontend**: HTML5 + Bootstrap 5.3 + JavaScript vanilla
- **Database**: MySQL 8.0+ (compartida con sistema admin)
- **Payments**: ePayco (pasarela de pagos Colombia)
- **Messaging**: WhatsApp API
- **Hosting**: Namecheap Shared Hosting (cPanel)

### Project Status
🚧 **EN DESARROLLO** (November 2025)
- Arquitectura definida
- Compartiendo base de datos con sistema admin
- Features core en implementación

## Production Environment Setup (Namecheap)

### Production Hosting Details
- **Hosting Provider**: Namecheap Shared Hosting
- **Domain**: kyoshop.co (Main Domain)
- **Server**: server277.web-hosting.com
- **SSH User**: kyosankk
- **Document Root**: /home/kyosankk/public_html/

### Hosting Limits & Capabilities
- **Subdomains**: 30 available
- **Databases**: 50 available
- **Storage**: Shared hosting resources
- **SSL**: Available (Let's Encrypt)

### Domain Structure
```
kyoshop.co                            # Main domain → Online Store (THIS PROJECT)
├── public_html/                      # Document root
├── Repository: kyoshop-store
└── Database: kyosankk_inventory (READ-ONLY)

inventory.kyoshop.co                  # Admin System (OTHER REPO)
├── public_html/inventory/
├── Repository: kyoshop-inventory
└── Database: kyosankk_inventory (FULL ACCESS)

dev.kyoshop.co                        # Development Store (THIS PROJECT)
└── TBD
```

### Production Database Configuration
```php
// config/database.php (production)
private $host = 'localhost';
private $db_name = 'kyosankk_inventory';  // ← SHARED with admin system
private $username = 'kyosankk_store';      // ← READ-ONLY user (to create)
private $password = '[production_password]';
```

### Production Application Configuration
```php
// config/config.php (production)
define('APP_URL', 'https://kyoshop.co');
define('WHATSAPP_NUMBER', '+57300XXXXXXX');
define('EPAYCO_PUBLIC_KEY', 'test_xxx');
define('EPAYCO_PRIVATE_KEY', 'test_xxx');
```

### SSH Access
```bash
# Connect to production server
ssh kyosankk@server277.web-hosting.com

# Navigate to store directory
cd /home/kyosankk/public_html/
```

## Database Sharing Strategy

### ⚠️ CRITICAL: Read-Only Access

Este proyecto **SOLO LEE** de la base de datos. No puede modificar productos, stock, o precios.

```sql
-- Crear usuario READ-ONLY para la tienda (ejecutar en admin)
CREATE USER 'kyosankk_store'@'localhost' IDENTIFIED BY 'secure_password';

-- Dar permisos SOLO de lectura
GRANT SELECT ON kyosankk_inventory.productos TO 'kyosankk_store'@'localhost';
GRANT SELECT ON kyosankk_inventory.categorias TO 'kyosankk_store'@'localhost';

-- La tienda tiene sus propias tablas para pedidos, carritos, usuarios
GRANT ALL PRIVILEGES ON kyosankk_inventory.pedidos TO 'kyosankk_store'@'localhost';
GRANT ALL PRIVILEGES ON kyosankk_inventory.carrito TO 'kyosankk_store'@'localhost';
GRANT ALL PRIVILEGES ON kyosankk_inventory.clientes_web TO 'kyosankk_store'@'localhost';

FLUSH PRIVILEGES;
```

### Shared Tables (Read-Only)
- `productos` - Catálogo de productos
- `categorias` - Categorías (si existe)

### Store-Only Tables (Full Access)
- `pedidos` - Pedidos de clientes
- `carrito` - Carritos de compra activos
- `clientes_web` - Usuarios registrados en la tienda
- `transacciones` - Log de pagos ePayco

## Architecture

### MVC Structure
```
/kyoshop-store/
├── index.php                 # Front Controller (routing)
├── config/
│   ├── database.php         # DB connection (READ-ONLY)
│   ├── config.php           # App settings
│   └── epayco.php           # ePayco credentials
├── models/
│   ├── Producto.php         # Products (read-only)
│   ├── Pedido.php           # Orders
│   ├── Carrito.php          # Shopping cart
│   └── Cliente.php          # Web customers
├── controllers/
│   ├── HomeController.php   # Landing page
│   ├── ProductoController.php
│   ├── CarritoController.php
│   ├── CheckoutController.php
│   └── PedidoController.php
├── views/
│   ├── layouts/public.php   # Main layout
│   ├── home/index.php       # Homepage
│   ├── productos/
│   │   ├── index.php        # Product catalog
│   │   └── detalle.php      # Product detail
│   ├── carrito/index.php    # Shopping cart
│   └── checkout/
│       ├── index.php        # Checkout form
│       └── confirmacion.php # Order confirmation
├── assets/
│   ├── css/store.css        # Custom styles
│   ├── js/store.js          # Custom JS
│   └── img/                 # Store images (logos, icons)
├── uploads/                 # Product images (shared or synced)
├── .github/workflows/       # GitHub Actions
├── .htaccess               # Apache config
├── .gitignore              # Git ignore
└── README.md               # Project documentation
```

## Key Features

### ✅ Implemented
- TBD (proyecto recién iniciado)

### 🚧 In Development
- [ ] Catálogo público de productos
- [ ] Sistema de carrito de compras
- [ ] Integración con WhatsApp
- [ ] Integración con ePayco
- [ ] Checkout process
- [ ] Gestión de pedidos

### 📋 Planned
- [ ] Sistema de usuarios/registro
- [ ] Seguimiento de pedidos
- [ ] Wishlist
- [ ] Reseñas de productos
- [ ] Newsletter
- [ ] Cupones de descuento

## Security Measures

- Database user con permisos READ-ONLY para productos
- Prepared statements para prevenir SQL injection
- CSRF tokens en formularios
- Sanitización de inputs
- Validación de pagos con ePayco webhooks
- HTTPS obligatorio en producción
- Headers de seguridad en .htaccess

## Git Strategy

### Branch Structure (GitHub Flow)
```
main (producción - kyoshop.co)
├── develop (desarrollo)
├── feature/nombre
└── hotfix/bug-critico
```

### Reglas Importantes de Git
- **NUNCA editar la rama `main` directamente**
- **TODO cambio a `main` DEBE hacerse mediante Pull Request (PR)**
- Workflow obligatorio: `develop` → crear PR → revisión → merge a `main`
- GitHub Actions despliega automáticamente después del merge

### File Management
- **Code**: Tracked in Git
- **Product Images**: Shared with admin OR synced
- **Config**: Secrets managed via .htaccess environment variables
- **Uploads**: `.gitignore` configured

## Integration with Admin System

### Data Flow
```
Admin System (inventory.kyoshop.co)
└── Modifica productos/stock/precios
    ↓
Database (kyosankk_inventory)
    ↓
Online Store (kyoshop.co)
└── Lee productos en tiempo real
    └── Clientes ven stock actualizado
```

### Important Notes
- **Stock updates**: Real-time from admin
- **New products**: Appear immediately in store
- **Price changes**: Reflect instantly
- **Orders**: Created by store, viewable in admin (future)

## ePayco Integration

### Configuration
```php
// config/epayco.php
define('EPAYCO_PUBLIC_KEY', getenv('EPAYCO_PUBLIC_KEY'));
define('EPAYCO_PRIVATE_KEY', getenv('EPAYCO_PRIVATE_KEY'));
define('EPAYCO_TEST_MODE', true); // false in production
```

### Payment Flow
1. Cliente agrega productos al carrito
2. Procede a checkout
3. ePayco procesa el pago
4. Webhook confirma transacción
5. Sistema crea pedido
6. Notificación por email/WhatsApp

## WhatsApp Integration

### Direct Order via WhatsApp
- Botón en cada producto
- Mensaje pre-llenado con detalles
- Alternativa al checkout online

```javascript
const message = `
Hola, me interesa este producto:
- ${producto.nombre}
- Talla: ${talla}
- Color: ${color}
- Precio: ${precio}
`;
window.open(`https://wa.me/57300XXXXXXX?text=${encodeURIComponent(message)}`);
```

## Development Commands

### Testing on Development Server
All testing should be done on the development server at https://dev.kyoshop.co after pushing to the `develop` branch.

## Deployment

### GitHub Actions Auto-Deploy
- **Trigger**: Push to `main` branch
- **Destination**: /home/kyosankk/public_html/
- **Environment vars**: Injected via .htaccess
- **Permissions**: Set automatically

### Manual Deploy via SSH
```bash
# Connect to server
ssh kyosankk@server277.web-hosting.com

# Navigate to directory
cd /home/kyosankk/public_html/

# Pull latest changes
git pull origin main

# Update .htaccess with production credentials
nano .htaccess
```

## Common Development Patterns

### Reading Products (Read-Only)
```php
// models/Producto.php
public function obtenerTodos() {
    // Solo SELECT queries permitidas
    $sql = "SELECT * FROM productos WHERE activo = 1";
    return $this->db->fetchAll($sql);
}
```

### Creating Orders (Full Access)
```php
// models/Pedido.php
public function crear($datos) {
    // INSERT permitido en tablas propias
    $sql = "INSERT INTO pedidos (cliente_id, total, ...) VALUES (...)";
    return $this->db->insert($sql, $datos);
}
```

## Error Handling

- Development: Error reporting ON
- Production: Errors logged, user sees friendly message
- Payment errors: Log and notify admin
- Stock errors: Prevent purchase if out of stock

## Performance Considerations

- Product catalog cached (considerar Redis futuro)
- Images lazy loaded
- CSS/JS minified in production
- Database queries optimized
- CDN for static assets (futuro)

## Testing

### Manual Testing Checklist
- [ ] Product catalog loads
- [ ] Add to cart works
- [ ] Cart persists (sessions/localStorage)
- [ ] Checkout process completes
- [ ] ePayco payment successful
- [ ] Order created in database
- [ ] WhatsApp integration works
- [ ] Responsive design (mobile/tablet)

## Future Enhancements

### Phase 1 - MVP
- Catálogo de productos
- Carrito básico
- WhatsApp checkout
- ePayco payments

### Phase 2 - Features
- User accounts/login
- Order tracking
- Wishlist
- Product reviews
- Email notifications

### Phase 3 - Advanced
- Recommendation engine
- Loyalty program
- Advanced analytics
- Mobile app (PWA)

## Important Links

- **Admin System Repo**: https://github.com/IngCristhian/kyoshop-inventory
- **Store Production**: https://kyoshop.co
- **Admin Production**: https://inventory.kyoshop.co
- **ePayco Docs**: https://docs.epayco.co
- **WhatsApp Business API**: https://business.whatsapp.com

---

**Maintained by**: Cristian Alvis
**Last Updated**: November 2025
**Version**: 1.0.0-dev
