<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\View\View;
use App\Service\Http\Response;
use App\Service\Http\Request;
use App\Service\FormValidator\ContactFormValidator;
use App\Model\ArticleRepository;


final class HomeController
{
    public function __construct(private readonly View $view, private readonly ContactFormValidator $contactFormValidator, private readonly ArticleRepository $articleRepository)
    {
    }

    public function index(Request $request): Response
    {
        $articles = $this->articleRepository->findAll();

        if ($request->getMethod() === 'POST') {
            $response = $this->contactFormValidator->isValid($request->request()->all());
            if (!$response) {
                return new Response($this->view->render([
                    'template' => 'home',
                    'data' => [
                        'articles' => $articles,
                        'errors' => $this->contactFormValidator->getErrors(),
                        'success' => []
                    ]
                ]));
            } else {
                return new Response($this->view->render([
                    'template' => 'home',
                    'data' => [
                        'articles' => $articles,
                        'errors' => [],
                        'success' => ['Votre message a bien été envoyé']
                    ]
                ]));
            }
        }

        return new Response($this->view->render([
            'template' => 'home',
            'data' => [
                'articles' => $articles,
                'errors' => [],
                'success' => []
            ]
        ]));
    }

    public function contactForm($formValidator): Response
    {
        $isFormValid = $formValidator->isValid($_POST);
        if ($isFormValid['status'] === 200) {
            $email = $_POST['email'];
            $message = $_POST['message'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            try {
                $isMailSend = mail('haloche035@gmail.com', 'Contact', "Message de $prenom $nom : $message", "From: $email");
            } catch (\Throwable $th) {
                $isMailSend = false;
            }
            $message = $isMailSend ? 'Votre message a bien été envoyé' : 'Une erreur est survenue lors de l\'envoi de votre message';
            return new Response(json_encode(['message' => $message]), $isMailSend ? 200 : 500);
        } else {
            return new Response(json_encode(['data' => $isFormValid]), $isFormValid['status']);
        }
    }
}
