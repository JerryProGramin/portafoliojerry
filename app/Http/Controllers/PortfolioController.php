<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\View;
use App\Domain\Projects\ProjectRepository;
use App\Domain\Technologies\TechnologyRepository;
use App\Support\Config;

final class PortfolioController
{
    public function __construct(
        private ProjectRepository $projects,
        private TechnologyRepository $technologies,
        private View $view
    ) {
    }

    public function index(): void
    {
        $this->view->render('portfolio.index', [
            'title' => 'Inicio',
            'projects' => $this->projects->published(),
            'technologyGroups' => $this->technologies->groupedByCategory(),
            'projectFilters' => $this->technologies->projectFilters(),
            'flash' => $_SESSION['flash'] ?? null,
            'contact' => [
                'email' => Config::string('CONTACT_TO_EMAIL'),
                'linkedin' => Config::string('CONTACT_LINKEDIN_URL'),
                'whatsapp' => preg_replace(
                    '/\D+/',
                    '',
                    Config::string('CONTACT_WHATSAPP_NUMBER')
                ),
            ],
        ]);

        unset($_SESSION['flash']);
    }
}
