# Sistema de Gestión de Presupuestos - Agencia Digital

Sistema completo de gestión de presupuestos desarrollado en PHP puro con arquitectura MVC y patrón Active Record.

## 🚀 Acceso Rápido

**URL**: http://props.test

**Credenciales de prueba**:
- Email: `admin@agency.com`
- Password: `admin123`

## 📋 Requisitos

- PHP 8.1 o superior
- SQLite (PDO)
- Apache con mod_rewrite
- Composer

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.2+ (OOP, PSR-4)
- **Base de datos**: SQLite
- **Frontend**: Alpine.js 3.x + Tailwind CSS 3.x (CDN)
- **Arquitectura**: MVC con Active Record
- **Autenticación**: Sesiones PHP nativas

## 📦 Instalación

```bash
# Clonar o descargar el proyecto
cd /var/www/html/props

# Instalar dependencias (solo autoloader)
composer install

# Dar permisos a la carpeta de base de datos
chmod 755 database
chmod 664 database/budget.db

# Configurar Apache virtual host para props.test
# La aplicación está lista para usar
```

## 🏗️ Estructura del Proyecto

```
props/
├── public/              # Entry point
├── src/
│   ├── Config/         # Database connection
│   ├── Core/           # BaseModel, Router, helpers
│   ├── Middleware/     # Auth middleware
│   ├── Models/         # User, Client, Project, Budget, BudgetItem
│   ├── Controllers/    # Business logic
│   └── Views/          # PHP templates
├── database/
│   ├── budget.db       # SQLite database
│   └── migrations/     # SQL migrations
└── vendor/             # Composer autoload
```

## ✨ Funcionalidades

### Autenticación
- Login/Logout con sesiones PHP
- Control de acceso por roles (admin/user)
- Passwords hasheados con bcrypt

### Dashboard
- Estadísticas en tiempo real
- Accesos rápidos
- Sidebar colapsable (preferencia guardada en localStorage)

### Gestión de Usuarios (Solo Admin)
- CRUD completo
- Roles: admin y user
- Cambio seguro de contraseñas

### Gestión de Clientes
- CRUD completo
- Información de contacto y empresa

### Gestión de Proyectos
- CRUD completo
- Asociación a clientes
- Estados: activo, completado, cancelado

### Gestión de Presupuestos
- CRUD completo
- Asociación a proyectos
- **Gestión de conceptos/items**
- Cálculo automático de totales
- IVA configurable (default 21%)
- Estados: borrador, enviado, aprobado, rechazado
- Fecha de validez

## 🔒 Seguridad

- ✅ Password hashing con `password_hash()`
- ✅ Prepared statements (SQL injection protection)
- ✅ HTML escaping con `htmlspecialchars()`
- ✅ Sesiones PHP seguras
- ✅ Middleware de autenticación
- ✅ Control de acceso basado en roles
- ✅ Foreign keys habilitadas

## 🎨 UI/UX

- Diseño responsive (Tailwind CSS)
- Interactividad con Alpine.js
- Validación frontend y backend
- Formato de moneda y fechas
- Badges de estado con colores semánticos
- Confirmaciones de eliminación

## 📚 Rutas Principales

### Públicas
- `/login` - Iniciar sesión

### Protegidas
- `/dashboard` - Panel principal
- `/clients` - Gestión de clientes
- `/projects` - Gestión de proyectos
- `/budgets` - Gestión de presupuestos

### Solo Admin
- `/users` - Gestión de usuarios

## 🧪 Testing

1. Acceder a http://props.test
2. Login con `admin@agency.com` / `admin123`
3. Crear un cliente
4. Crear un proyecto asociado al cliente
5. Crear un presupuesto asociado al proyecto
6. Añadir conceptos al presupuesto
7. Verificar cálculos automáticos

## 📝 Base de Datos

La base de datos SQLite se crea automáticamente en `database/budget.db` con las siguientes tablas:

- `users` - Usuarios del sistema
- `clients` - Clientes
- `projects` - Proyectos
- `budgets` - Presupuestos
- `budget_items` - Conceptos de presupuestos

## 🔧 Desarrollo

El proyecto sigue los principios:
- PSR-4 autoloading
- Active Record pattern
- MVC architecture
- Separation of concerns
- DRY (Don't Repeat Yourself)

## 📄 Licencia

Este proyecto es software de código abierto bajo la **Licencia MIT**.

**Términos clave:**
- Se permite el uso comercial.
- Se permite la modificación y distribución.
- Se permite el uso privado.
- Se requiere mantener el aviso de copyright y la licencia original en todas las copias.

Desarrollado por **webestudio** ([bravojorge56@gmail.com](mailto:bravojorge56@gmail.com))  
Sitio web: [jorgebravo.info](https://jorgebravo.info)

---

**Desarrollado con PHP puro, sin frameworks**
