# Solución al error "could not find driver"

## Problema
El driver PDO SQLite no está instalado para PHP 8.3 (usado por Apache).

## Solución

Ejecuta estos comandos en orden:

```bash
# 1. Instalar el módulo SQLite para PHP 8.3
sudo apt update
sudo apt install -y php8.3-sqlite3

# 2. Reiniciar Apache
sudo systemctl restart apache2

# 3. Verificar que está instalado
php -m | grep -i pdo_sqlite
```

## Verificación

Después de ejecutar los comandos, accede a:
**http://props.test**

Deberías ver la página de login sin errores.

## Credenciales

```
Email: admin@agency.com
Password: admin123
```

---

**Nota**: Si Apache usa una versión diferente de PHP, reemplaza `8.3` por la versión correcta (8.4 o 8.5).
