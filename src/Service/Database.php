<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use Exception;
use PDOStatement;
use App\Service\DotEnv;

(new DotEnv('../.env'))->load();

final class Database
{
    public function __construct()
    {
    }

    public function connect(): PDO
    {
        try {
            return new PDO(getenv('DATABASE_DNS'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function prepare(string $query): PDOStatement
    {
        return $this->connect()->prepare($query);
    }

    public function query(string $query): PDOStatement
    {
        return $this->connect()->query($query);
    }

    public function exec(string $query): int|false
    {
        return $this->connect()->exec($query);
    }
}
