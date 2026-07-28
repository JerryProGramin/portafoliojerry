<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Technologies\TechnologyRepository;
use PDO;

final class PdoTechnologyRepository implements TechnologyRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function groupedByCategory(): array
    {
        $statement = $this->pdo->query(
            'SELECT name, slug, icon, category
             FROM technologies
             WHERE is_visible = 1
             ORDER BY category_order ASC, sort_order ASC, name ASC'
        );

        $groups = [];
        foreach ($statement->fetchAll() as $technology) {
            $groups[$technology['category']][] = $technology;
        }

        return $groups;
    }

    public function projectFilters(): array
    {
        $statement = $this->pdo->query(
            "SELECT DISTINCT t.name, t.slug, t.icon, t.sort_order
             FROM technologies t
             INNER JOIN project_technologies pt ON pt.technology_id = t.id
             INNER JOIN projects p ON p.id = pt.project_id
             WHERE t.is_visible = 1
               AND p.status = 'published'
             ORDER BY t.sort_order ASC, t.name ASC"
        );

        return $statement->fetchAll();
    }
}
