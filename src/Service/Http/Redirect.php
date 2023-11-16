<?php

declare(strict_types=1);

namespace App\Service\Http;

final class Redirect
{
    public function to(string $url): void
    {
        header('Location: ' . $url, true);
        exit;
    }
}
