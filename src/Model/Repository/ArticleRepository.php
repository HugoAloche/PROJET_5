<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Service\Database;
use App\Model\Entity\Article;
use App\Model\Repository\Interfaces\EntityRepositoryInterface;
use ArrayObject;

final class ArticleRepository implements EntityRepositoryInterface
{
    public function __construct(private readonly Database $bdd)
    {
    }

    public function find(int $id): ?object
    {
        $this->bdd->connect();
        $query = $this->bdd->prepare('SELECT * FROM article WHERE idarticle = :id');
        $query->execute(['id' => $id]);
        $data = $query->fetch();
        return new Article(
            $data['idarticle'],
            $data['title'],
            $data['content'],
            $data['chapo'],
            $data['creationDate'],
            $data['updateDate']
        );
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?object
    {
        $this->bdd->connect();
        $query = $this->bdd->prepare('SELECT * FROM article WHERE idarticle = :id');
        $query->execute($criteria);
        $data = $query->fetch();
        return new Article(
            $data['idarticle'],
            $data['title'],
            $data['content'],
            $data['chapo'],
            $data['creationDate'],
            $data['updateDate']
        );
    }

    public function findAll(): ?ArrayObject
    {
        $this->bdd->connect();
        $query = $this->bdd->prepare('SELECT * FROM article');
        $query->execute();
        $data = $query->fetchAll();
        $articles = new ArrayObject();
        foreach ($data as $article) {
            $articles->append(new Article(
                $article['idarticle'],
                $article['title'],
                $article['content'],
                $article['chapo'],
                $article['creationDate'],
                $article['updateDate']
            ));
        }
        return $articles;
    }

    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        $this->bdd->connect();
        $query = $this->bdd->prepare('SELECT * FROM article WHERE idarticle = :id');
        $query->execute($criteria);
        $data = $query->fetchAll();
        $articles = [];
        foreach ($data as $article) {
            $articles[] = new Article(
                $article['idarticle'],
                $article['title'],
                $article['content'],
                $article['chapo'],
                $article['creationDate'],
                $article['updateDate']
            );
        }
        return $articles;
    }

    public function create(object $entity): bool
    {
        return false;
    }

    public function update(object $entity): bool
    {
        return false;
    }

    public function delete(object $entity): bool
    {
        return false;
    }
}
