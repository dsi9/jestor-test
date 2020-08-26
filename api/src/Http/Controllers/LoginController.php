<?php

namespace App\Http\Controllers;

use App\Lib\Controller;
use App\Lib\Request;
use App\Lib\Response;
use App\Lib\Validator;
use App\Services\UserService;

class LoginController extends Controller
{
    /** @var UserService */
    private $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->service = new UserService();
    }

    public function loginAction(): Response
    {
        Validator::make($this->request()->request->all(), ['email', 'password'])->validate();

        $basicAuth = $this->service->login(
            $this->request()->request->get('email'),
            $this->request()->request->get('password')
        );

        return Response::json(['basic' => $basicAuth]);
    }
}
