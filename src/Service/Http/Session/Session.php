<?php

declare(strict_types=1);

namespace App\Service\Http\Session;

final class Session
{
    private readonly SessionParametersBag $sessionParamBag;

    public function __construct()
    {
        session_start();
        $this->sessionParamBag = new SessionParametersBag($_SESSION);
    }

    public function set(string $name, mixed $value): void
    {
        $this->sessionParamBag->set($name, $value);
    }

    public function get(string $name): mixed
    {
        return $this->sessionParamBag->get($name);
    }

    public function toArray(): ?array
    {
        return $this->sessionParamBag->all();
    }

    public function remove(string $name): void
    {
        $this->sessionParamBag->unset($name);
    }

    public function addFlashes(string $type, string|array $message): void
    {
        $flashes = $this->get('flashes');
        if (is_array($message)) {
            foreach ($message as $msg) {
                $flashes[$type][] = $msg;
            }
        } else {
            $flashes[$type][] = $message;
        }
        $this->set('flashes', $flashes);
    }

    public function getFlashes(): ?array
    {
        $flashes = $this->get('flashes');
        $this->remove('flashes');

        return $flashes;
    }
}
