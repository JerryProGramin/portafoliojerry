<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Projects\ProjectRepository;
use PDO;

final class PdoProjectRepository implements ProjectRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function published(): array
    {
        $statement = $this->pdo->query(
            "SELECT
                p.id,
                p.title,
                p.slug,
                p.subtitle,
                p.summary,
                p.status,
                p.demo_url,
                p.repository_url,
                COALESCE(GROUP_CONCAT(t.slug ORDER BY t.sort_order SEPARATOR ' '), '') AS technology_slugs
             FROM projects p
             LEFT JOIN project_technologies pt ON pt.project_id = p.id
             LEFT JOIN technologies t ON t.id = pt.technology_id AND t.is_visible = 1
             WHERE p.status = 'published'
             GROUP BY p.id, p.title, p.slug, p.subtitle, p.summary, p.status, p.demo_url, p.repository_url,
                      p.featured, p.sort_order
             ORDER BY p.featured DESC, p.sort_order ASC, p.id DESC"
        );

        return $statement->fetchAll();
    }
}
