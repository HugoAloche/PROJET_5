<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Service\FormValidator\ContactValidator;
use App\Model\ArticleRepository;
use App\Service\SendEmail;


final class HomeController
{
    public function __construct(private readonly View $view, private readonly Session $session, private readonly ContactValidator $contactValidator, private readonly ArticleRepository $articleRepository, private readonly SendEmail $sendEmail)
    {
    }

    public function index(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            $isValid = $this->contactValidator->isValid($request->request()->all());
            if ($isValid) {
                $isSend = $this->sendEmail->sendContact();
                if ($isSend) {
                    $this->session->addFlashes('success', 'Votre message a bien été envoyé');
                } else {
                    $this->session->addFlashes('error', 'Une erreur est survenue lors de l\'envoi de votre message');
                }
            } else {
                $this->session->addFlashes('error', $this->contactValidator->getErrors());
            }
        }

        $articles = $this->articleRepository->findAll();

        return new Response($this->view->render([
            'template' => 'home',
            'data' => [
                'articles' => $articles
            ]
        ]));
    }
}
