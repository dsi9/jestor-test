<?php

namespace App\Lib\Database\Builder;

class Where
{
    /** @var string */
    private $column;

    /** @var string */
    private $operator;

    /** @var null|string|int */
    private $value;

    public function __construct(string $column, string $operator, $value = null)
    {
        $this->column   = $column;
        $this->operator = $operator;
        $this->value    = $value;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
