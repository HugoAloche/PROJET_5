<?php

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Request;
use App\Model\ArticleRepository;

final class ArticleController
{
    public function __construct(private readonly View $view, private readonly ArticleRepository $articleRepository)
    {
    }

    public function index(Request $request): Response
    {
        $article = $this->articleRepository->findOneById($request->query()->get('id'));
        return new Response($this->view->render([
            'template' => 'article',
            'data' => [
                'article' => $article,
                'errors' => [],
                'success' => []
            ]
        ]));
    }
}
