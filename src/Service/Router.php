<?php

declare(strict_types=1);

namespace  App\Service;

use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Database;
use App\Controller\Frontoffice\HomeController;
use App\View\View;

final class Router
{
    private readonly View $view;
    private readonly Session $session;
    private readonly Database $database;

    public function __construct(private readonly Request $request)
    {
        $this->database = new Database();
        $this->session = new Session();
        $this->view = new View($this->session);
    }

    public function run(): Response
    {
        $action = $this->request->query()->has('action') ? $this->request->query()->get('action') : 'home';

        // *** @Route http://localhost:8000/?action=home ***
        if ($action === 'home') {
            $controller = new HomeController($this->view);
            return $controller->index();
        }

        return new Response("Error 404 - la page : <b>{$this->request->query()->get('action')}</b> n'existe pas.<br><a href='index.php?action=home'>Aller Ici</a>", 404);
    }
}
