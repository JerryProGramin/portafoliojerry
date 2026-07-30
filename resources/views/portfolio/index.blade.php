@extends('layouts.main')

@section('content')
<div class="page">
    <div class="intro-screen">
    <section class="hero-min" id="inicio">
        <div class="hero-media">
            <div class="avatar">
                <img src="{{ asset('img/henry.webp') }}" alt="Henry Sánchez" width="200" height="200">
            </div>
        </div>
        <div class="hero-text">
            <p class="kicker">Backend | Web Developer</p>
            <h2 class="sub">Bienvenido</h2>
            <h1 class="title">Soy, Henry Sánchez</h1>
            <p class="bio">
                Técnico en Desarrollo de Software con orientación backend y experiencia creando
                soluciones web y móviles con PHP, JavaScript, Java, Python, Dart y MySQL.
            </p>
            <div class="hero-actions">
                <a class="btn" href="{{ asset('docs/HenrySanchezChinguelCV.pdf') }}" target="_blank" rel="noopener">
                    <i class="fa-regular fa-file-pdf"></i> Ver CV
                </a>
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
    </div>

    <section id="proyectos" class="one-page-section reveal">
        <div class="projects-heading">
            <p class="kicker">Trabajo seleccionado</p>
            <h2>Mis proyectos</h2>
            <p class="lead">Explora mis trabajos por tipo de desarrollo y tecnología.</p>
        </div>

        @if(!empty($projectTypes))
            <div class="type-filters" role="group" aria-label="Filtrar proyectos por tipo">
                <button class="type-filter active" type="button" data-type="all" aria-pressed="true">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i> Todos
                </button>
                @foreach($projectTypes as $type)
                    <button class="type-filter" type="button" data-type="{{ $type['slug'] }}" aria-pressed="false">
                        @if(!empty($type['icon']))
                            <i class="{{ $type['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ $type['name'] }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="projects-layout">
            <aside class="project-filter-panel">
                <h3>Filtrar por tecnología</h3>
                <label class="filter-search">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <span class="sr-only">Buscar proyecto o tecnología</span>
                    <input id="project-search" type="search" placeholder="Buscar...">
                </label>

                <button class="technology-filter active" type="button" data-technology="all" aria-pressed="true">
                    Todas las tecnologías
                </button>

                @foreach($projectFilters as $filter)
                    @if($loop->first || $projectFilters[$loop->index - 1]['category'] !== $filter['category'])
                        <p class="filter-category">{{ $filter['category'] }}</p>
                    @endif
                    <button class="technology-filter" type="button" data-technology="{{ $filter['slug'] }}" aria-pressed="false">
                        @if(!empty($filter['icon']))
                            <i class="{{ $filter['icon'] }}" aria-hidden="true"></i>
                        @endif
                        {{ $filter['name'] }}
                    </button>
                @endforeach
            </aside>

            <div class="project-grid">
                @forelse($projects as $project)
                    <article
                        class="project-card"
                        data-type="{{ strtolower($project['project_type']) }}"
                        data-technologies="{{ $project['technology_slugs'] }}"
                        data-search="{{ strtolower($project['title'] . ' ' . $project['summary'] . ' ' . $project['technology_slugs']) }}"
                    >
                        <div class="project-cover">
                            <i class="fa-solid fa-code" aria-hidden="true"></i>
                        </div>
                        <div class="project-content">
                            <span class="project-type">{{ $project['project_type'] }}</span>
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <div class="project-technologies">
                                @foreach($project['technologies'] as $technology)
                                    <span>
                                        @if(!empty($technology['icon']))
                                            <i class="{{ $technology['icon'] }}" aria-hidden="true"></i>
                                        @endif
                                        {{ $technology['name'] }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="project-actions">
                                @if(!empty($project['repository_url']))
                                    <a class="btn" href="{{ $project['repository_url'] }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-github"></i> Código
                                    </a>
                                @endif
                                @if(!empty($project['demo_url']))
                                    <a class="btn btn-primary" href="{{ $project['demo_url'] }}" target="_blank" rel="noopener">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Demo
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="project-card"><p>Aún no hay proyectos publicados.</p></article>
                @endforelse
                <p class="projects-empty" id="projects-empty" hidden>No hay proyectos para este filtro.</p>
            </div>
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
