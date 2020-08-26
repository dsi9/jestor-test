<?php

namespace App;

use App\Exceptions\NotFoundException;
use App\Http\Middleware\MiddlewareInterface;
use App\Lib\Exceptions\HttpException;
use App\Lib\Request;
use App\Lib\Response;
use App\Lib\Routes;
use Throwable;

class Server
{
    /** @var Request */
    private $request;

    /** @var string[] */
    private $middlewares;

    public function __construct()
    {
        $this->createRequest();
    }

    private function requestAttributes(): Request\Attributes
    {
        return new Request\Attributes($_GET['q']);
    }

    private function createRequest(): void
    {
        $this->request = new Request($_GET, $_POST, $this->requestAttributes(), $_SERVER);
    }

    public function middlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    private function applyMiddlewares(Routes\Router $router): void
    {
        if (empty($router->getMiddlewares())) {
            return;
        }

        foreach ($router->getMiddlewares() as $middlewareName) {
            $className = $this->middlewares[$middlewareName] ?? null;
            if ($className !== null) {
                $middleware = new $className;
                assert($middleware instanceof MiddlewareInterface);
                $middleware->handle($this->request);
            }
        }
    }

    private function matchRouter(): Response
    {
        $routes = require_once __DIR__ . '/../routes/routes.php';

        assert($routes instanceof Routes);

        $router = $routes->collection->findByRequest($this->request);

        if ($router !== null) {
            $this->applyMiddlewares($router);

            [$className, $method] = explode('::', $router->getClassNameMethod());

            $controller = new $className($this->request);

            return call_user_func_array([$controller, $method], array_filter([$this->request->attributes->getId()]));
        }

        throw new NotFoundException();
    }

    private function handle(Throwable $exception): Response
    {
        if (!$exception instanceof HttpException) {
            $exception = new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return Response::json($exception->jsonSerialize(), $exception->getHttpCode());
    }

    public function run()
    {
        try {
            $response = $this->matchRouter();
        } catch (Throwable $exception) {
            $response = $this->handle($exception);
        }

        $response->send();
    }
}
