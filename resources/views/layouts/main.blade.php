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
    <canvas class="starfield" id="starfield" aria-hidden="true"></canvas>

    <header class="site-header">
        <a class="brand" href="#inicio">Portafolio</a>
        <div class="header-socials" aria-label="Redes profesionales">
            @foreach($socialLinks as $social)
                @if(!empty($social['url']))
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['name'] }}">
                        <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                    </a>
                @else
                    <span class="social-disabled" aria-label="{{ $social['name'] }} pendiente de configurar" title="{{ $social['name'] }} pendiente de configurar">
                        <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                    </span>
                @endif
            @endforeach
        </div>
    </header>

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

    <div class="theme-switch" role="group" aria-label="Seleccionar tema">
        <button type="button" data-theme-choice="light" aria-label="Activar modo claro" title="Modo claro">
            <i class="fa-regular fa-sun" aria-hidden="true"></i>
        </button>
        <button type="button" data-theme-choice="dark" aria-label="Activar modo oscuro" title="Modo oscuro">
            <i class="fa-regular fa-moon" aria-hidden="true"></i>
        </button>
    </div>

    <main>
        @yield('content')
    </main>
</body>
</html>
