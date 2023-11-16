<?php

declare(strict_types=1);

namespace App\Model\Entity;

final class Article
{
    public function __construct(
        private readonly int $idarticle,
        private readonly string $title,
        private readonly string $content,
        private readonly string $chapo,
        private readonly string $creationDate,
        private readonly ?string $updateDate
    ) {
    }

    public function getIdarticle(): int
    {
        return $this->idarticle;
    }

    public function getTitle(): string
    {
        return htmlspecialchars($this->title);
    }

    public function getContent(): string
    {
        return htmlspecialchars($this->content);
    }

    public function getChapo(): string
    {
        return htmlspecialchars($this->chapo);
    }

    public function getCreationDate(): string
    {
        return htmlspecialchars($this->creationDate);
    }

    public function getUpdateDate(): string
    {
        return htmlspecialchars($this->updateDate);
    }

    public function setTitle(string $title): void
    {
        $this->title = htmlspecialchars($title);
    }

    public function setContent(string $content): void
    {
        $this->content = htmlspecialchars($content);
    }

    public function setChapo(string $chapo): void
    {
        $this->chapo = htmlspecialchars($chapo);
    }

    public function setCreationDate(string $creationDate): void
    {
        $this->creationDate = htmlspecialchars($creationDate);
    }

    public function setUpdateDate(string $updateDate): void
    {
        $this->updateDate = htmlspecialchars($updateDate);
    }
}
