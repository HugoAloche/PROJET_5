<?php

declare(strict_types=1);

namespace  App\Service;

use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Database;
use App\Controller\Frontoffice\HomeController;
use App\Controller\Frontoffice\ArticleController;
use App\Service\FormValidator\ContactValidator;
use App\Model\ArticleRepository;
use App\View\View;
use App\Service\SendEmail;

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
            $this->database->connect();
            $controller = new HomeController($this->view, $this->session, new ContactValidator($this->request, [], []), new ArticleRepository($this->database), new SendEmail($this->request));
            return $controller->index($this->request);
        } elseif ($action === 'article') {
            $controller = new ArticleController($this->view, new ArticleRepository($this->database));
            return $controller->index($this->request);
        }

        return new Response("Error 404 - la page : <b>{$this->request->query()->get('action')}</b> n'existe pas.<br><a href='index.php?action=home'>Aller Ici</a>", 404);
    }
}
