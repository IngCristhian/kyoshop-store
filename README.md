# KyoShop - Online Store 🛍️

Tienda online (ecommerce) para venta de ropa desarrollada en PHP puro. Parte del ecosistema KyoShop.

## 📦 Proyectos Relacionados

Este es **uno de dos repositorios** del proyecto KyoShop:

1. **[kyoshop-inventory](https://github.com/IngCristhian/kyoshop-inventory)** - Sistema Administrativo
   - Gestión de inventario, ventas, clientes
   - https://inventory.kyoshop.co

2. **kyoshop-store** (ESTE REPO) - Tienda Online
   - Ecommerce público para clientes
   - https://kyoshop.co

Ambos **comparten la misma base de datos** en el mismo servidor.

## 🚀 Features

- ✅ Catálogo público de productos
- ✅ Carrito de compras
- ✅ Integración con WhatsApp
- ✅ Pasarela de pagos ePayco
- ✅ Checkout seguro
- ✅ Responsive design (mobile-first)
- 🚧 Sistema de usuarios (próximamente)
- 🚧 Seguimiento de pedidos (próximamente)

## 🛠️ Tech Stack

- **Backend**: PHP 8.2+ (sin frameworks)
- **Frontend**: HTML5 + Bootstrap 5.3 + JavaScript vanilla
- **Database**: MySQL 8.0+ (compartida con admin)
- **Payments**: ePayco
- **Hosting**: Namecheap cPanel

## 📁 Estructura del Proyecto

```
kyoshop-store/
├── config/           # Configuraciones (DB, app, ePayco)
├── models/           # Modelos de datos
├── controllers/      # Controladores MVC
├── views/            # Vistas PHP
├── assets/           # CSS, JS, imágenes
├── uploads/          # Imágenes de productos
├── sql/              # Referencia a migraciones (ver admin repo)
└── .github/workflows # GitHub Actions para deploy
```

## 🗄️ Base de Datos

**⚠️ IMPORTANTE**: Las migraciones SQL están en el repo **admin**.

Este proyecto comparte la base de datos `kyosankk_inventory` con el sistema administrativo:

- **Tablas compartidas** (READ-ONLY): `productos`, `categorias`
- **Tablas propias** (FULL ACCESS): `pedidos`, `carrito`, `clientes_web`, `transacciones`

Ver: [sql/README.md](sql/README.md) para más detalles.

## 🚀 Deployment

### Producción
- **Domain**: https://kyoshop.co
- **Deploy**: Automático via GitHub Actions al hacer push a `main`
- **Document Root**: `/home/kyosankk/public_html/`

### Desarrollo
- **Domain**: https://dev.kyoshop.co
- **Deploy**: Automático via GitHub Actions al hacer push to `develop`

### GitHub Secrets Necesarios

```
SSH_HOST
SSH_USER
SSH_PRIVATE_KEY
SSH_PORT
DEPLOY_PATH_PRD          # /home/kyosankk/public_html/
DEPLOY_PATH_STORE_DEV    # Path to dev environment

DB_NAME                  # kyosankk_inventory
DB_USER_STORE            # Usuario READ-ONLY
DB_PASSWORD_STORE
DB_NAME_DEV
DB_USER_STORE_DEV
DB_PASSWORD_STORE_DEV

WHATSAPP_NUMBER          # +57300XXXXXXX
EPAYCO_PUBLIC_KEY
EPAYCO_PRIVATE_KEY
EPAYCO_PUBLIC_KEY_TEST
EPAYCO_PRIVATE_KEY_TEST
```

## 💻 Desarrollo Local

```bash
# Clonar el repositorio
git clone https://github.com/IngCristhian/kyoshop-store.git
cd kyoshop-store

# Configurar .htaccess con credenciales locales
cp .htaccess.example .htaccess
# Editar .htaccess con tus credenciales

# Iniciar servidor PHP
php -S localhost:8001

# Abrir en navegador
open http://localhost:8001
```

## 🔐 Seguridad

- Usuario de BD con permisos READ-ONLY para productos
- Prepared statements (prevención SQL injection)
- CSRF tokens en formularios
- Sanitización de inputs
- Headers de seguridad en .htaccess
- HTTPS obligatorio en producción

## 📝 Git Workflow

```bash
# Feature/bugfix
git checkout -b feature/nueva-funcionalidad
# ... hacer cambios ...
git commit -m "feat: descripción"
git push origin feature/nueva-funcionalidad
# Crear PR a develop

# Release
# PR de develop → main
# GitHub Actions despliega automáticamente
```

**⚠️ NUNCA hacer push directo a `main`** - Siempre usar Pull Requests

## 🔗 Links Útiles

- **Producción**: https://kyoshop.co
- **Admin**: https://inventory.kyoshop.co
- **Desarrollo**: https://dev.kyoshop.co
- **Admin Repo**: https://github.com/IngCristhian/kyoshop-inventory
- **ePayco Docs**: https://docs.epayco.co

## 📄 Licencia

Proyecto privado - Todos los derechos reservados

## 👤 Autor

Cristian Alvis - [@IngCristhian](https://github.com/IngCristhian)

---

Para más información detallada, consulta [CLAUDE.md](CLAUDE.md)
# kyoshop-store
