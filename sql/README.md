# SQL Migrations - KyoShop Store

## ⚠️ IMPORTANTE: Las migraciones están en el repositorio admin

Este proyecto **comparte la misma base de datos** con el sistema administrativo.

**Todas las migraciones SQL están centralizadas en:**
- Repository: https://github.com/IngCristhian/kyoshop-inventory
- Directory: `/sql/`

## Cómo ejecutar migraciones

1. Ve al repositorio admin: `kyoshop-inventory`
2. Navega a la carpeta `sql/`
3. Ejecuta las migraciones en orden numérico
4. Las nuevas tablas del store también se agregan ahí

## Base de datos compartida

```
kyosankk_inventory (Base de Datos Única)
├── Tablas del Admin
│   ├── productos
│   ├── ventas
│   ├── clientes
│   └── ...
│
└── Tablas del Store (nuevas)
    ├── pedidos (órdenes online)
    ├── carrito (carritos de compra)
    ├── clientes_web (usuarios tienda)
    └── transacciones (pagos ePayco)
```

## Permisos

- **Admin System**: Full access (SELECT, INSERT, UPDATE, DELETE)
- **Store System**:
  - READ-ONLY en tablas de productos
  - Full access en tablas propias (pedidos, carrito, etc.)

## Schema Reference

Para ver la estructura completa de la base de datos, consulta:
`kyoshop-inventory/sql/`
