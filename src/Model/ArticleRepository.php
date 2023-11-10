<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;
use App\Entity\Article;
use ArrayObject;

final class ArticleRepository
{
    public function __construct(private readonly Database $bdd)
    {
    }

    public function findAll(): ArrayObject
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

    public function findOneById(int $id): ?Article
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
}
