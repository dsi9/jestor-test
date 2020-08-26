<?php

namespace App\Http\Controllers;

use App\Lib\Controller;
use App\Lib\Request;
use App\Lib\Response;
use App\Lib\Validator;
use App\Models\ToDo;
use App\Services\TodoListService;

class TodoListController extends Controller
{
    /** @var TodoListService */
    private $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->service = new TodoListService();
    }

    public function getAction(int $id = null): Response
    {
        $data = null;

        if ($id !== null) {
            $toDo = $this->service->find($id);
            $data = !empty($toDo) ? $toDo->jsonSerialize() : null;
        }

        if ($id === null) {
            $toDos = $this->service->getAll();
            $data  = array_map(function (ToDo $toDo) {
                return $toDo->jsonSerialize();
            }, $toDos);
        }

        return Response::json($data);
    }

    public function postAction(): Response
    {
        Validator::make($this->request()->request->all(), ['subject', 'description', 'date'])->validate();

        $toDo = $this->service->create(
            $this->request()->request->get('subject'),
            $this->request()->request->get('description'),
            $this->request()->request->get('date')
        );

        return Response::json($toDo->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function putAction(int $id): Response
    {
        Validator::make($this->request()->request->all(), ['subject', 'description', 'date'])->validate();

        $toDo = $this->service->update(
            $id,
            $this->request()->request->get('subject'),
            $this->request()->request->get('description'),
            $this->request()->request->get('date')
        );

        return Response::json($toDo->jsonSerialize(), Response::HTTP_ACCEPTED);
    }

    public function deleteAction(int $id): Response
    {
        $this->service->delete($id);

        return Response::json(null, Response::HTTP_NO_CONTENT);
    }
}
