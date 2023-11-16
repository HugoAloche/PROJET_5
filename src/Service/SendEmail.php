<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;

final class SendEmail
{
    public function __construct(private readonly Request $request)
    {
    }

    public function sendContact(): bool
    {
        $email = $this->request->request()->get('email');
        $message = $this->request->request()->get('message');
        $nom = $this->request->request()->get('nom');
        $prenom = $this->request->request()->get('prenom');
        try {
            return mail('haloche035@gmail.com', 'Contact', "Message de $prenom $nom : $message", "From: $email");
        } catch (\Throwable $th) {
            return false;
        }
    }
}
