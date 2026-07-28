<?php

declare(strict_types=1);

namespace App\Core;

use eftec\bladeone\BladeOne;

final class View
{
    private BladeOne $blade;

    public function __construct()
    {
        $this->blade = new BladeOne(
            base_path('resources/views'),
            base_path('storage/cache/views'),
            \eftec\bladeone\BladeOne::MODE_AUTO
        );
    }

    public function render(string $view, array $data = []): void
    {
        echo $this->blade->run($view, $data);
    }
}
