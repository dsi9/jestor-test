<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use App\Lib\Request;
use App\Services\UserService;

class BasicAuth implements MiddlewareInterface
{
    private function isLogged($username, $password, $authorization): bool
    {
        $userService = new UserService();

        try {
            $basic = $userService->login($username, $password);
            return $basic == substr($authorization, 6);
        } catch (UnauthorizedException $exception) {
            return false;
        }
    }

    public function handle(Request $request): void
    {
        $authorization = $request->server->get('HTTP_AUTHORIZATION');

        if (preg_match('/^basic/i', $authorization)) {
            [$username, $password] = explode(':', base64_decode(substr($authorization, 6)));

            if ($this->isLogged($username, $password, $authorization)) {
                return;
            }
        }

        throw new UnauthorizedException();
    }
}
