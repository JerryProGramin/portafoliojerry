# Portafolio Jerry

Portafolio personal público, dinámico y optimizado. La aplicación muestra proyectos y tecnologías desde MariaDB utilizando una cuenta con permisos exclusivos de lectura.

## Tecnologías

- PHP 8.2+
- FastRoute
- BladeOne
- PDO y MariaDB
- Alpine.js
- GSAP
- GLightbox
- Vite
- CSS propio

## Instalación

1. Copia `.env.example` como `.env` y configura la conexión de solo lectura.
2. Crea la base de datos mediante `database/schema.sql`.
3. Instala las dependencias:

```bash
composer install
npm install
```

4. Compila los recursos:

```bash
npm run build
```

5. Inicia el servidor apuntando a `public/`:

```bash
php -S localhost:8000 -t public
```

## Seguridad

Esta aplicación es exclusivamente pública y de consulta. El usuario de base de datos configurado en `.env` debe tener solamente permisos `SELECT` sobre:

- `projects`
- `project_images`
- `technologies`
- `project_technologies`

El futuro panel administrativo debe ser una aplicación separada, autenticada y con credenciales de base de datos diferentes.
