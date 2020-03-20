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
    protected $indent = 0;
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

    private function analyze($sample)
    {
        if ($this->isJsonArray($sample)) {
            $this->stackParenthesis();
            foreach ($sample as $value) {
                $this->analyze($value);
            }
        } elseif (is_string($sample)) {
            $valueColor = $this->stringColor($sample);
            $value = $this->stringValue($sample);
            $this->stackString($value, $valueColor);
        } else {
            $this->stackBrackets();
            foreach ($sample as $key => $value) {
                $valueColor = $this->stringColor($value);
                $value = $this->stringValue($value);
                $this->stackKeyValue($key, $value, $valueColor);
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

    private function indent()
    {
        return str_repeat(' ', 4 * $this->indent);
    }

    private function stackBrackets()
    {
        $this->stack($this->indent() . "<span style=\"color:black\">}</span>");
        $this->stack($this->indent() . "<span style=\"color:black\">{</span>");

        $this->cursor++;
        $this->indent++;
    }

    private function stackParenthesis()
    {
        $this->stack($this->indent() . "<span style=\"color:black\">]</span>");
        $this->stack($this->indent() . "<span style=\"color:black\">[</span>");

        $this->cursor++;
        $this->indent++;
    }

    private function stackKeyValue($key, $value, $valueColor)
    {
        $this->stack($this->indent() . "<span style=\"color:black\">$key</span>: <span style=\"color:$valueColor\">$value</span>");

        $this->cursor++;
    }

    private function stackString($value, $valueColor)
    {
        $this->stack($this->indent() . "<span style=\"color:$valueColor\">$value</span>");

        $this->cursor++;
    }

    private function stack($string)
    {
        array_splice($this->stack, $this->cursor, 0, $string);
    }

    private function isJsonArray($sample)
    {
        if (is_string($sample)) {
            return false;
        }

        foreach (array_keys($sample) as $key) {
            if (is_integer($key)) {
                return true;
            }
        }

        return false;
    }
}
