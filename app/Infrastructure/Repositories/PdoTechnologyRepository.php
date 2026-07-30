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
            "SELECT t.name, t.slug, t.icon, t.category, t.category_order, t.sort_order
             FROM technologies t
             WHERE t.is_visible = 1
               AND t.category IN (
                   'Lenguajes',
                   'Marcado y estilos',
                   'Frameworks y librerías',
                   'Bases de datos'
               )
             ORDER BY t.category_order ASC, t.sort_order ASC, t.name ASC"
        );

        return $statement->fetchAll();
    }
}
