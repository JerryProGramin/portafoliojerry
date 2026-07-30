CREATE DATABASE IF NOT EXISTS portafolio_jerry
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE portafolio_jerry;

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(160) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    subtitle VARCHAR(200) NULL,
    summary TEXT NOT NULL,
    description LONGTEXT NULL,
    project_type VARCHAR(50) NOT NULL DEFAULT 'Full Stack',
    status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
    featured BOOLEAN NOT NULL DEFAULT FALSE,
    sort_order INT NOT NULL DEFAULT 0,
    demo_url VARCHAR(500) NULL,
    repository_url VARCHAR(500) NULL,
    published_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_projects_public (status, featured, sort_order)
);

CREATE TABLE IF NOT EXISTS project_types (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    icon VARCHAR(100) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_visible BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS social_links (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    url VARCHAR(500) NULL,
    icon VARCHAR(100) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_visible BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO social_links (name, slug, url, icon, sort_order)
VALUES
    ('GitHub', 'github', 'https://github.com/JerryProGramin', 'fa-brands fa-github', 1),
    ('LinkedIn', 'linkedin', NULL, 'fa-brands fa-linkedin-in', 2)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    icon = VALUES(icon),
    sort_order = VALUES(sort_order);

INSERT INTO project_types (name, slug, icon, sort_order)
VALUES
    ('Frontend', 'frontend', 'fa-solid fa-display', 1),
    ('Backend', 'backend', 'fa-solid fa-server', 2),
    ('App móvil', 'mobile', 'fa-solid fa-mobile-screen', 3),
    ('Full Stack', 'full-stack', 'fa-solid fa-code', 4)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    icon = VALUES(icon),
    sort_order = VALUES(sort_order);

CREATE TABLE IF NOT EXISTS project_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    path VARCHAR(500) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    caption VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_cover BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_project_images_project
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS technologies (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    icon VARCHAR(100) NULL,
    category VARCHAR(80) NOT NULL,
    category_order INT NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    is_visible BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_technologies_public (is_visible, category_order, sort_order)
);

CREATE TABLE IF NOT EXISTS project_technologies (
    project_id BIGINT UNSIGNED NOT NULL,
    technology_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (project_id, technology_id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (technology_id) REFERENCES technologies(id) ON DELETE CASCADE
);

INSERT INTO projects
    (title, slug, subtitle, summary, status, featured, sort_order, published_at)
VALUES
    (
        'Sistema de Gestión de Reportes',
        'sistema-gestion-reportes',
        'Automatización de registro y control',
        'Módulo web para registrar actividades, evidencias y estados con trazabilidad.',
        'published',
        TRUE,
        1,
        NOW()
    ),
    (
        'Dashboard Y',
        'dashboard-y',
        'Visualización de indicadores',
        'Panel para visualizar indicadores y facilitar la toma de decisiones.',
        'published',
        FALSE,
        2,
        NOW()
    )
ON DUPLICATE KEY UPDATE title = VALUES(title);
