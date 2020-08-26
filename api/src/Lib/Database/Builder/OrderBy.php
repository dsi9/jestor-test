<?php

namespace App\Lib\Database\Builder;

class OrderBy
{
    /** @var string */
    private $column;

    /** @var string */
    private $direction;

    public function __construct(string $column, string $direction = 'ASC')
    {
        $this->column    = $column;
        $this->direction = $direction;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
