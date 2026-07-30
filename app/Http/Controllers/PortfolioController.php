<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\View;
use App\Domain\Projects\ProjectRepository;
use App\Domain\Social\SocialLinkRepository;
use App\Domain\Technologies\TechnologyRepository;
use App\Support\Config;

final class PortfolioController
{
    public function __construct(
        private ProjectRepository $projects,
        private TechnologyRepository $technologies,
        private SocialLinkRepository $socialLinks,
        private View $view
    ) {
    }

    public function index(): void
    {
        $projects = $this->projects->published();
        $this->view->render('portfolio.index', [
            'title' => 'Inicio',
            'projects' => $projects,
            'projectTypes' => $this->projects->types(),
            'technologyGroups' => $this->technologies->groupedByCategory(),
            'projectFilters' => $this->technologies->projectFilters(),
            'socialLinks' => $this->socialLinks->visible(),
            'flash' => $_SESSION['flash'] ?? null,
            'contact' => [
                'email' => Config::string('CONTACT_TO_EMAIL'),
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
