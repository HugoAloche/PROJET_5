<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Database;

final class HomeController
{
    public function __construct(private readonly View $view)
    {
    }

    public function index(): Response
    {
        $database = new Database();
        $database->connect();
        // TODO à créer et à importer depuis un repo
        $articles = [
            [
                'id' => '1',
                'title' => 'Article 1',
                'chapo' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                'author' => 'John Doe',
                'created_at' => '2021-01-01 12:00:00',
                'src' => 'source.png',
                'alt' => 'alt'
            ],
            [
                'id' => '2',
                'title' => 'Article 2',
                'chapo' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
                'author' => 'John Doe',
                'created_at' => '2021-01-01 12:00:00',
                'src' => 'source.png',
                'alt' => 'alt'
            ]
        ];
        return new Response($this->view->render([
            'template' => 'home',
            'data' => [
                'articles' => $articles
            ]
        ]));
    }
}
