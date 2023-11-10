<?php

declare(strict_types=1);

namespace App\Service\FormValidator;

use App\Service\FormValidator\AbstractValidator;

final class ContactValidator extends AbstractValidator
{
    public function isValid(): bool
    {
        $this->validate('nom', 'required');
        $this->validate('nom', 'maxLength', 50);
        $this->validate('nom', 'notNumeric');
        $this->validate('nom', 'notSpecialChar');
        $this->validate('prenom', 'required');
        $this->validate('prenom', 'maxLength', 50);
        $this->validate('prenom', 'notNumeric');
        $this->validate('prenom', 'notSpecialChar');
        $this->validate('email', 'email');
        $this->validate('message', 'required');
        $this->validate('message', 'minLength', 10);
        $this->validate('message', 'maxLength', 500);
        $this->validate('rgpd', 'isOn');
        return empty($this->errors);
    }
}
