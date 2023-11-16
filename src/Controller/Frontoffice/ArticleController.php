<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Request;
use App\Model\Repository\ArticleRepository;

final class ArticleController
{
    public function __construct(private readonly View $view, private readonly ArticleRepository $articleRepository)
    {
    }

    public function index(Request $request): Response
    {
        $article = $this->articleRepository->findOneBy(['id' => $request->query()->get('id')]);
        return new Response($this->view->render([
            'template' => 'article',
            'data' => [
                'article' => $article
            ]
        ]));
    }

    public function allArticles(): Response
    {
        $articles = $this->articleRepository->findAll();
        return new Response($this->view->render([
            'template' => 'allArticles',
            'data' => [
                'articles' => $articles
            ]
        ]));
    }
}
