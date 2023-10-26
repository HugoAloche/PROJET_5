<?php

declare(strict_types=1);

namespace App\Service\FormValidator;

use App\Service\Http\Request;

abstract class AbstractValidator
{
    protected array $errors = [];
    protected Request $request;
    protected array $data;

    public function __construct(Request $request, array $data, array $errors)
    {
        $this->request = $request;
        $this->data = $data;
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
