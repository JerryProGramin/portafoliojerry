@extends('layouts.main')

@section('content')
<div class="page">
    <section class="hero-min" id="inicio">
        <div class="hero-text">
            <p class="kicker">Backend | Web Developer</p>
            <h2 class="sub">Bienvenido</h2>
            <h1 class="title">Soy, Henry Sánchez</h1>
            <p class="bio">
                Técnico en Desarrollo de Software con orientación backend y experiencia creando
                soluciones web y móviles con PHP, JavaScript, Java, Python, Dart y MySQL.
            </p>
            <div class="hero-actions">
                <a class="btn" href="#proyectos"><i class="fa-regular fa-folder-open"></i> Ver proyectos</a>
                <a class="btn" href="#contacto"><i class="fa-regular fa-message"></i> Contactar</a>
                <a class="btn" href="{{ asset('docs/HenrySanchezChinguelCV.pdf') }}" target="_blank" rel="noopener">
                    <i class="fa-regular fa-file-pdf"></i> Ver CV
                </a>
            </div>
        </div>
        <div class="hero-media">
            <div class="avatar">
                <img src="{{ asset('img/henry.webp') }}" alt="Henry Sánchez" width="200" height="200">
            </div>
        </div>
    </section>

    <section id="stack" class="stack-section reveal">
        <h2>Stack técnico</h2>
        <p class="lead">Lenguajes, frameworks y herramientas que utilizo con frecuencia.</p>
        <div class="grid" style="margin-top:16px">
            @forelse($technologyGroups as $category => $technologies)
                <article class="card">
                    <h3 class="card-h">{{ $category }}</h3>
                    <div class="chips">
                        @foreach($technologies as $technology)
                            <span class="chip">
                                @if(!empty($technology['icon']))
                                    <i class="{{ $technology['icon'] }}" aria-hidden="true"></i>
                                @endif
                                {{ $technology['name'] }}
                            </span>
                        @endforeach
                    </div>
                </article>
            @empty
                <article class="card">
                    <p>Aún no hay tecnologías visibles.</p>
                </article>
            @endforelse
        </div>
    </section>

    <section id="proyectos" class="one-page-section reveal">
        <h2>Proyectos</h2>
        <p class="lead">Una selección de soluciones enfocadas en automatización y gestión de información.</p>

        @if(!empty($projectFilters))
            <div class="project-filters" role="group" aria-label="Filtrar proyectos por tecnología">
                <button class="filter-button active" type="button" data-filter="all" aria-pressed="true">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                    Todos
                </button>
                @foreach($projectFilters as $filter)
                    <button class="filter-button" type="button" data-filter="{{ $filter['slug'] }}" aria-pressed="false">
                        @if(!empty($filter['icon']))
                            <i class="{{ $filter['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ $filter['name'] }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="grid project-grid">
            @forelse($projects as $project)
                <article class="card project-card" data-technologies="{{ $project['technology_slugs'] }}">
                    <div class="card-title">
                        <div>
                            <h3>{{ $project['title'] }}</h3>
                            @if(!empty($project['subtitle']))
                                <p>{{ $project['subtitle'] }}</p>
                            @endif
                        </div>
                        <span class="badge">{{ ucfirst($project['status']) }}</span>
                    </div>
                    <p style="margin:10px 0 14px">{{ $project['summary'] }}</p>
                    <div style="display:flex; gap:10px; flex-wrap:wrap">
                        @if(!empty($project['demo_url']))
                            <a class="btn btn-primary" href="{{ $project['demo_url'] }}" target="_blank" rel="noopener">Demo</a>
                        @endif
                        @if(!empty($project['repository_url']))
                            <a class="btn" href="{{ $project['repository_url'] }}" target="_blank" rel="noopener">Código</a>
                        @endif
                    </div>
                </article>
            @empty
                <article class="card"><p>Aún no hay proyectos publicados.</p></article>
            @endforelse
        </div>
    </section>

    <section id="contacto" class="one-page-section reveal">
        <div class="section contact-section">
            <p class="kicker">Hablemos</p>
            <h2>Contacto</h2>
            <p class="lead">Puedes encontrarme directamente en estos medios.</p>
            <div class="contact-links">
                <a class="contact-link" href="mailto:{{ $contact['email'] }}">
                    <span class="contact-icon"><i class="fa-regular fa-envelope"></i></span>
                    <span>
                        <small>Correo</small>
                        <strong>{{ $contact['email'] }}</strong>
                    </span>
                </a>
                @if(!empty($contact['linkedin']))
                    <a class="contact-link" href="{{ $contact['linkedin'] }}" target="_blank" rel="noopener">
                        <span class="contact-icon"><i class="fa-brands fa-linkedin-in"></i></span>
                        <span><small>LinkedIn</small><strong>Ver perfil profesional</strong></span>
                    </a>
                @endif
                @if(!empty($contact['whatsapp']))
                    <a class="contact-link" href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener">
                        <span class="contact-icon"><i class="fa-brands fa-whatsapp"></i></span>
                        <span><small>WhatsApp</small><strong>Iniciar conversación</strong></span>
                    </a>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
