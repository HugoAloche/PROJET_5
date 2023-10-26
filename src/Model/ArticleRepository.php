<?php

declare(strict_types=1);

namespace App\Model;

final class ArticleRepository
{
    public function __construct(private readonly \PDO $pdo)
    {
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare('SELECT * FROM article');
        $query->execute();
        return $query->fetchAll();
    }

    public function findOneById(int $id): array
    {
        $query = $this->pdo->prepare('SELECT * FROM article WHERE idarticle = :id');
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    public function insert(array $data): void
    {
        $query = $this->pdo->prepare('INSERT INTO article (title, chapo, content, author, created_at, src, alt) VALUES (:title, :chapo, :content, :author, :created_at, :src, :alt)');
        $query->execute($data);
    }

    public function update(array $data): void
    {
        $query = $this->pdo->prepare('UPDATE article SET title = :title, chapo = :chapo, content = :content, author = :author, created_at = :created_at, src = :src, alt = :alt WHERE id = :id');
        $query->execute($data);
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM article WHERE id = :id');
        $query->execute(['id' => $id]);
    }
}
