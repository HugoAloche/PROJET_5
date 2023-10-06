<?php

declare(strict_types=1);

namespace App\Service\Http;

final class Response
{
    public function __construct(
        private readonly string $content = '',
        private readonly int $statusCode = 200,
        private readonly array $headers = []
    ) {
    }

    public function send(): int
    {
        // echo $this->statusCode . ' ' . implode(',', $this->headers);
        echo $this->content;
        return http_response_code($this->statusCode);
    }
}
