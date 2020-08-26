<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Models\User;

class UserService
{
    /** @var User */
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function login(string $email, string $password): string
    {
        $user = $this->model->where('email', '=', $email)
                            ->first();

        if ($user instanceof User && password_verify($password, $user->getPassword())) {
            return base64_encode(sprintf('%s:%s', $email, $password)); // TODO: Não recomendavel. Apenas para o teste
        }

        throw new UnauthorizedException("Email or password incorrect.");
    }
}