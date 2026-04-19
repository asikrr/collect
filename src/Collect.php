<?php

namespace Collect;

class Collect
{
    private array $array = [];

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function get($key = null)
    {
        return $this->array[$key] ?? $this->array;
    }

    public function first()
    {
        return $this->array[array_key_first($this->array)];
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function map(callable $callback): Collect
    {
        return new self(array_map($callback, $this->array));
    }

    public function each(callable $callback, ...$args): Collect
    {
        foreach ($this->array as $key => $item) {
            $callback($item, $key, ...$args);
        }
        return $this;
    }

    public function push($value, $key = null): Collect
    {
        if (gettype($value) === 'array') {
            $value = new self($value);
        }
        if ($key) {
            $this->array[$key] = $value;
        } else {
            $this->array[] = $value;
        }
        return $this;
    }

    public function unshift($value): Collect
    {
        array_unshift($this->array, $value);
        return $this;
    }

    public function shift(): Collect
    {
        array_shift($this->array);
        return $this;
    }

    public function pop(): Collect
    {
        array_pop($this->array);
        return $this;
    }

    public function splice($idx, $length = 1): Collect
    {
        array_splice($idx, $length);
        return $this;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->array);
    }

    public function find(callable $callback)
    {
        foreach ($this->array as $key => $item) {
            if ($callback($item, $key)) {
                return $item;
            }
        }
        return null;
    }

    public function filter(callable $callback): Collect
    {
        return new self(array_filter($this->array, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function sort(string $direction = 'asc'): Collect
    {
        $sorted = $this->array;
        
        if (strtolower($direction) === 'desc') {
            arsort($sorted);
        } else {
            asort($sorted);
        }
        
        return new self($sorted);
    }
}