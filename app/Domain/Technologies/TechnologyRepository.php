<?php

declare(strict_types=1);

namespace App\Domain\Technologies;

interface TechnologyRepository
{
    public function groupedByCategory(): array;

    public function projectFilters(): array;
}
