<?php

namespace App\Lib;

use Closure;

class Collection
{
    /** @var array */
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param mixed $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->items[$key] ?? null;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value): self
    {
        $this->items[$key] = $value;
        return $this;
    }

    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return mixed|null
     */
    public function where(Closure $call): Collection
    {
        $result = array_filter($this->items, $call);

        return new Collection($result);
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return count($this->items) === 0 ? null : reset($this->items);
    }
}
