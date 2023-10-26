<?php

declare(strict_types=1);

namespace App\Service\FormValidator;

use App\Service\FormValidator\AbstractValidator;

final class ContactFormValidator extends AbstractValidator
{
    public function isValid(): bool
    {
        $this->validate('nom', 'required');
        $this->validate('nom', 'minLength', 2);
        $this->validate('nom', 'maxLength', 50);
        $this->validate('prenom', 'required');
        $this->validate('prenom', 'minLength', 2);
        $this->validate('prenom', 'maxLength', 50);
        $this->validate('email', 'email');
        $this->validate('message', 'required');
        $this->validate('message', 'minLength', 10);
        $this->validate('message', 'maxLength', 500);
        $this->validate('rgpd', 'isOn');
        return empty($this->errors);
    }

    private function validate(string $name, string $rule): void
    {
        $value = $this->request->request()->get($name);
        $method = 'validate' . ucfirst($rule);
        $this->$method($name, $value, ...array_slice(func_get_args(), 2));
    }

    private function validateRequired(string $name, string $value): void
    {
        if (empty($value)) {
            $this->errors[] = 'Le champ ' . $name . ' est requis';
        }
    }

    private function validateEmail(string $name, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Le champ ' . $name . ' doit être un email valide';
        }
    }

    private function validateMinLength(string $name, string $value, int $min): void
    {
        if (strlen($value) < $min) {
            $this->errors[] = 'Le champ ' . $name . ' doit contenir au moins ' . $min . ' caractères';
        }
    }

    private function validateMaxLength(string $name, string $value, int $max): void
    {
        if (strlen($value) > $max) {
            $this->errors[] = 'Le champ ' . $name . ' doit contenir au maximum ' . $max . ' caractères';
        }
    }

    private function validateIsOn(string $name, string $value): void
    {
        if ($value !== 'on') {
            $this->errors[] = 'Le champ ' . $name . ' doit être coché';
        }
    }
}
