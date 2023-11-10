<?php

declare(strict_types=1);

namespace App\Service\FormValidator;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;

abstract class AbstractValidator
{
    protected array $errors = [];
    protected Request $request;
    protected Session $session;
    protected array $data;

    public function __construct(Request $request, array $data, array $errors)
    {
        $this->request = $request;
        $this->data = $data;
        $this->errors = $errors;
    }

    public function validate(string $name, string $rule): void
    {
        $value = $this->request->request()->get($name);
        $method = 'validate' . ucfirst($rule);
        $this->$method($name, trim($value), ...array_slice(func_get_args(), 2));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateRequired(string $name, string $value): void
    {
        if (empty($value)) {
            $this->errors[] = "Le champ {$name} est requis";
        }
    }

    private function validateEmail(string $name, string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Le champ {$name} doit être un email valide";
        }
    }

    private function validateMinLength(string $name, string $value, int $min): void
    {
        if (strlen($value) < $min) {
            $this->errors[] = "Le champ {$name} doit contenir au moins {$min} caractères";
        }
    }

    private function validateMaxLength(string $name, string $value, int $max): void
    {
        if (strlen($value) > $max) {
            $this->errors[] = "Le champ {$name} doit contenir au maximum {$max} caractères";
        }
    }

    private function validateIsOn(string $name, string $value): void
    {
        if ($value !== 'on') {
            $this->errors[] = "Le champ {$name} doit être coché";
        }
    }


    private function validateNotNumeric(string $name, string $value): void
    {
        if (is_numeric($value)) {
            $this->errors[] = "Le champ {$name} ne doit pas être numérique";
        }
    }

    private function validateNotSpecialChar(string $name, string $value): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            $this->errors[] = "Le champ {$name} ne doit pas contenir de caractères spéciaux";
        }
    }
}
