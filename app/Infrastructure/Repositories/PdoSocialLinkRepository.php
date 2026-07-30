<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Social\SocialLinkRepository;
use PDO;

final class PdoSocialLinkRepository implements SocialLinkRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function visible(): array
    {
        $statement = $this->pdo->query(
            'SELECT name, slug, url, icon
             FROM social_links
             WHERE is_visible = 1
             ORDER BY sort_order ASC, name ASC'
        );

        return $statement->fetchAll();
    }
}
