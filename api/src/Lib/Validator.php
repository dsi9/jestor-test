<?php

namespace App\Lib;

use App\Lib\Exceptions\ValidatorException;

class Validator
{
    /** @var array */
    private $data;

    /** @var array */
    private $rules;

    public function __construct(array $data, array $rules)
    {
        $this->data  = $data;
        $this->rules = $rules;
    }


    public static function make(array $data, array $rules): self
    {
        return new static($data, $rules);
    }

    public function validate(): bool
    {
        $diff = array_diff($this->rules, array_keys($this->data));

        if (!empty($diff)) {
            throw new ValidatorException($diff);
        }

        return false;
    }
}
