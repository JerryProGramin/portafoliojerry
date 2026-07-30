<?php

declare(strict_types=1);

namespace App\Domain\Social;

interface SocialLinkRepository
{
    public function visible(): array;
}
