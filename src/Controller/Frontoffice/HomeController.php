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
        return new Response($this->view->render(['template' => 'home']));
    }
}
