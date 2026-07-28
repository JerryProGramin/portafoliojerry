<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portafolio de Henry Sánchez, desarrollador backend y web.">
    <title>{{ $title ?? 'Portafolio' }} | Portafolio Henry</title>
    <script>
        try {
            if (localStorage.getItem('portfolio-theme') === 'dark') {
                document.documentElement.dataset.theme = 'dark';
            }
        } catch (error) {}
    </script>
    <link rel="icon" href="{{ asset('img/icono.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(base_path('public/assets/css/style.css')) }}">
    {!! vite_tags('resources/js/app.js') !!}
</head>
<body>
    <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Abrir menú" aria-controls="main-navigation" aria-expanded="false">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
    </button>

    <button class="theme-toggle" id="theme-toggle" type="button" aria-label="Activar modo oscuro" title="Cambiar tema">
        <i class="fa-regular fa-moon" aria-hidden="true"></i>
    </button>

    <nav class="navigation" id="main-navigation" aria-label="Navegación principal">
        <ul>
            <li class="active" data-section="inicio">
                <a href="#inicio" aria-label="Inicio">
                    <span class="icon"><i class="fa-regular fa-house"></i></span>
                    <span class="title">Inicio</span>
                </a>
            </li>
            <li data-section="proyectos">
                <a href="#proyectos" aria-label="Proyectos">
                    <span class="icon"><i class="fa-regular fa-folder-open"></i></span>
                    <span class="title">Proyectos</span>
                </a>
            </li>
            <li data-section="contacto">
                <a href="#contacto" aria-label="Contacto">
                    <span class="icon"><i class="fa-regular fa-message"></i></span>
                    <span class="title">Contacto</span>
                </a>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
