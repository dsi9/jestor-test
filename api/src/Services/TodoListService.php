<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Lib\Model;
use App\Models\ToDo;
use DateTimeImmutable;

class TodoListService
{
    private $model;

    public function __construct()
    {
        $this->model = new ToDo();
    }

    /**
     * @return ToDo[]
     */
    public function getAll(): array
    {
        return $this->model->builder()
                           ->orderBy('id', 'DESC')
                           ->get();
    }

    /**
     * @param int $id
     * @return Model|ToDo|null
     */
    public function find(int $id): ?Model
    {
        $toDo = $this->model->find($id);

        if (!$toDo instanceof ToDo) {
            throw new NotFoundException("To do Not Found.");
        }

        return $toDo;
    }

    private function save(string $subject, string $description, string $date, ToDo $toDo = null): ToDo
    {
        $toDo = $toDo ?? new ToDo();

        $toDo->setSubject($subject)
             ->setDescription($description)
             ->setDate(new DateTimeImmutable($date));

        $toDo->saveOrCreate();

        return $toDo;
    }

    public function create(string $subject, string $description, string $date): ToDo
    {
        return $this->save($subject, $description, $date);
    }

    public function update(int $id, string $subject, string $description, string $date): ToDo
    {
        $toDo = $this->model->find($id);

        if (!$toDo instanceof ToDo) {
            throw new NotFoundException("To do Not Found.");
        }

        return $this->save($subject, $description, $date, $toDo);
    }

    public function delete(int $id): void
    {
        $toDo = $this->model->find($id);

        if (!$toDo instanceof ToDo) {
            throw new NotFoundException("To do Not Found.");
        }

        $toDo->delete();
    }
}