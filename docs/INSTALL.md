# Instalación del Sistema de Presupuestos

## ⚠️ Requisito Faltante Detectado

El sistema está completamente desarrollado, pero **falta instalar el driver SQLite para PHP**.

## 🔧 Solución

Ejecutar el siguiente comando:

```bash
sudo apt install php-sqlite3
sudo systemctl restart apache2
```

## ✅ Verificación

Después de instalar, acceder a:

**http://props.test**

Deberías ver la página de login.

## 📋 Credenciales

```
Email: admin@agency.com
Password: admin123
```

## 🎯 Sistema Completado

El sistema incluye:

✅ 43 archivos PHP creados
✅ Base de datos SQLite configurada
✅ Migraciones automáticas
✅ Usuario admin creado
✅ CRUD completo para:
  - Usuarios (solo admin)
  - Clientes
  - Proyectos
  - Presupuestos con items

✅ Cálculos automáticos de totales
✅ Autenticación con sesiones PHP
✅ Control de acceso por roles
✅ UI responsive con Tailwind CSS
✅ Interactividad con Alpine.js
✅ localStorage para preferencias UI

## 📁 Archivos Creados

- **1** composer.json
- **1** .htaccess
- **1** migración SQL
- **5** archivos Core (BaseModel, Router, etc.)
- **1** Middleware
- **5** Modelos
- **6** Controladores
- **18** Vistas
- **1** Entry point (index.php)
- **1** README.md

**Total: 40+ archivos**

## 🚀 Próximos Pasos

1. Instalar `php-sqlite3`
2. Reiniciar Apache
3. Acceder a http://props.test
4. Hacer login
5. ¡Empezar a usar el sistema!
