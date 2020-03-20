<?php

namespace Rcubitto\JsonPretty;

function dd()
{
    array_map(function($x) {
        var_dump($x);
    }, func_get_args());
    die;
}

class JsonPretty
{
    protected $cursor = 0;
    protected $stack = [];

    public static function format($sample)
    {
        return (new self)->analyze((array) $sample)->build();
    }

    //

    private function build()
    {
        return "<pre>" . implode(PHP_EOL, $this->stack) . "</pre>";
    }

    private function analyze($sample, $depth = 1)
    {
        if ($this->isArray($sample)) {
            $this->stackParenthesis($depth - 1);
            foreach ($sample as $value) {
                $this->analyze($value, $depth + 1);
            }
        } else {
            $this->stackBrackets($depth - 1);
            foreach ($sample as $key => $value) {
                $valueColor = $this->stringColor($value);
                $value = $this->stringValue($value);
                $this->stackKeyValue($depth, $key, $value, $valueColor);
            }
        }

        return $this;
    }

    private function stringColor($value)
    {
        if (is_string($value)) return 'green';

        if (is_bool($value)) return 'red';

        return 'blue'; // numbers
    }

    private function stringValue($value)
    {
        if (is_string($value)) return "\"$value\"";

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value;
    }

    private function indent($depth)
    {
        return str_repeat(' ', 4 * $depth);
    }

    private function stackBrackets($depth)
    {
        $this->stack($this->indent($depth) . "<span style=\"color:black\">}</span>");
        $this->stack($this->indent($depth) . "<span style=\"color:black\">{</span>");

        $this->cursor++;
    }

    private function stackParenthesis($depth)
    {
        $this->stack($this->indent($depth) . "<span style=\"color:black\">]</span>");
        $this->stack($this->indent($depth) . "<span style=\"color:black\">[</span>");

        $this->cursor++;
    }

    private function stackKeyValue($depth, $key, $value, $valueColor)
    {
        $this->stack($this->indent($depth) . "<span style=\"color:black\">$key</span>: <span style=\"color:$valueColor\">$value</span>");

        $this->cursor++;
    }

    private function stack($string)
    {
        array_splice($this->stack, $this->cursor, 0, $string);
    }

    private function isArray($sample)
    {
        foreach (array_keys($sample) as $key) {
            if (is_integer($key)) {
                return true;
            }
        }

        return false;
    }
}
