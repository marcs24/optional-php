<?php

namespace Utils;

class Optional implements \ArrayAccess
{
    private $value;
    private $errors = [];

    private function __construct($value) {
        $this->value = $value;
    }

    public static function of($value) : Optional
    {
        return new Optional($value);
    }

    public function __call(string $method, array $parameters) : Optional
    {
        if(method_exists($this->value, $method) && $this->chainWasNotBroken()) {
            $this->value = $this->value->$method($parameters);
        }
        else {
            $this->errors[] = "method {$method} does not exist";
        }
        return $this;
    }

    public function __get(string $name) : Optional
    {
        if(isset($this->value->{$name}) && $this->chainWasNotBroken()) {
            $this->value = $this->value->{$name};
        }
        else {
            $this->errors[] = "attribute {$name} does not exist";
        }
        return $this;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function printErrors() : string
    {
        return implode("\n", $this->getErrors());
    }

    public function log(callable $loggingFunction = null) : Optional
    {
        if ($loggingFunction == null)
            echo ($this->printErrors());
        else {
            $loggingFunction($this);
        }
        return $this;
    }

    private function chainWasBroken() : bool
    {
        return !$this->chainWasNotBroken();
    }

    private function chainWasNotBroken() : bool
    {
        return empty($this->errors);
    }

    public function get(callable $callback = null)
    {
        $value = $this->chainWasBroken() ? null : $this->value;
        if ($callback != null) {
            return $callback($value);
        }
        return $value;
    }

    public function orElseGet($value)
    {
        if ($this->chainWasBroken()) {
            return is_callable($value) ? $value() : $value;
        }
        return $this->value;
    }

    public function isEmpty() : bool
    {
        return empty($this->get());
    }

    public function isNotEmpty() : bool
    {
        return !$this->isEmpty();
    }

    public function offsetExists($offset) : bool
    {
        return is_array($this->value) && isset($this->value[$offset]);
    }

    public function offsetGet($offset) : Optional
    {
        if($this->offsetExists($offset) && $this->chainWasNotBroken()) {
            $this->value = $this->value[$offset];
        }
        else {
            $this->errors[] = "key {$offset} does not exist";
        }
        return $this;
    }

    public function offsetSet($offset, $value) {}

    public function offsetUnset($offset) {}
}