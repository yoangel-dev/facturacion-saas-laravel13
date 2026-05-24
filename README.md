# 🚀 Facturación SaaS Multi-Tenant (Laravel 13)

Sistema SaaS multi-tenant desarrollado con Laravel 13 para la gestión de empresas, usuarios, clientes y facturación, con aislamiento completo de datos entre tenants y paneles independientes para administración global y usuarios empresariales.

---

# ✨ Características principales

* Multi-tenant real con aislamiento de datos
* Gestión de múltiples empresas (tenants)
* Gestión de usuarios y roles
* Gestión de clientes
* Sistema de facturación
* Panel administrativo global
* Panel independiente por tenant
* Autenticación segura
* Middleware multi-tenant
* Arquitectura escalable y mantenible

---

# 🛠 Tecnologías utilizadas

* PHP 8.2
* Laravel 13
* MySQL 8
* Bootstrap 5
* Blade
* Eloquent ORM
* Laravel Breeze (Blade)
* Middleware Multi-Tenant

---

# 🏗 Arquitectura del sistema

## 👑 SuperAdmin

El SuperAdmin tiene acceso global al sistema:

* Gestión de tenants
* Gestión de usuarios globales
* Acceso al panel administrativo `/admin`

---

## 👥 Usuarios por Tenant

Cada empresa administra sus propios recursos:

* Gestión de clientes
* Gestión de facturas
* Acceso al panel `/panel`

---

# 🔐 Roles del sistema

| Rol        | Descripción               |
| ---------- | ------------------------- |
| SuperAdmin | Control total del sistema |
| Admin      | Administración del tenant |
| Usuario    | Gestión operativa         |

---

# 🔒 Aislamiento de datos (Multi-Tenant)

Cada usuario únicamente puede acceder a la información perteneciente a su empresa.

Las consultas se filtran automáticamente mediante:

```php
where('tenant_id', auth()->user()->tenant_id)
```

Esto garantiza un aislamiento total entre empresas.

---

# 🔑 Autenticación

Implementada con Laravel Breeze (Blade):

* Login personalizado
* Redirección automática a `/panel`
* Logout seguro
* Gestión de roles desde base de datos

---

# 🗄 Base de datos

## Tablas principales

* `tenants`
* `users`
* `clients`
* `invoices`

---

## Relaciones

* Un Tenant tiene muchos Usuarios
* Un Tenant tiene muchos Clientes
* Un Tenant tiene muchas Facturas
* Un Usuario pertenece a un Tenant

---

# 📦 Instalación

```bash
git clone https://github.com/yoangel-dev/facturacion-saas-laravel13.git

cd laravel-saas-multitenant

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve
```

---

# 👤 Usuario de prueba

| Tipo     | Credenciales             |
| -------- | ------------------------ |
| Email    | `superadmin@example.com` |
| Password | `password`               |

---

# 🌐 Paneles del sistema

| Panel                 | Ruta     |
| --------------------- | -------- |
| Administración global | `/admin` |
| Panel tenant          | `/panel` |

---

# ☁ Despliegue recomendado

## ✅ Railway

Ideal para despliegues rápidos y gratuitos.

## ✅ Render

Muy sencillo para aplicaciones Laravel pequeñas y medianas.

## ✅ Hostinger

Opción económica para producción.

## ✅ DigitalOcean App Platform

Ideal para proyectos SaaS profesionales y escalables.

---

# 📁 Estructura recomendada

```plaintext
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Services/
├── Policies/
└── Providers/
```

---

# 🔧 Funcionalidades futuras sugeridas

* Suscripciones con Stripe
* Facturación electrónica
* API REST
* Dashboard estadístico
* Exportación PDF/Excel
* Notificaciones por correo
* Soporte multi-idioma
* Logs de actividad
* Gestión avanzada de permisos

---

# 🚀 Flujo del sistema

```text
SuperAdmin
   │
   ├── Gestiona Tenants
   ├── Gestiona Usuarios
   └── Accede a /admin

Tenant
   │
   ├── Usuarios
   ├── Clientes
   └── Facturas
           │
           └── Acceso a /panel
```

---

# 🔐 Seguridad

* Middleware de autenticación
* Protección CSRF
* Aislamiento multi-tenant
* Validaciones de formularios
* Logout seguro
* Protección de rutas por roles

---

# 📄 Licencia

Este proyecto está bajo la licencia MIT.

---

# 🤝 Contribuciones

Las contribuciones, issues y pull requests son bienvenidos.

1. Haz un Fork
2. Crea una rama (`feature/nueva-funcionalidad`)
3. Haz commit de tus cambios
4. Haz push a la rama
5. Abre un Pull Request

---

# ⭐ Soporte

Si este proyecto te resulta útil:

* Dale una estrella al repositorio ⭐
* Comparte el proyecto
* Contribuye con mejoras

---

# 👨‍💻 Autor

Desarrollado por Yoangel Alayon Peguero con Laravel 13 y arquitectura SaaS Multi-Tenant.

---

# 📌 Repositorio

```bash
⭐ Star this repository
```
