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
    protected $fifo = []; // up
    protected $lifo = []; // down

    public static function format($sample)
    {
        return (new self)->process((array) $sample);
    }

    //

    private function process($sample)
    {
        $this->analyze($sample);

        return $this->build();
    }

    private function build()
    {
        return "<pre>" .
            implode(PHP_EOL, $this->fifo) .
            PHP_EOL .
            implode(PHP_EOL, array_reverse($this->lifo))
        . "</pre>";
    }

    private function analyze($sample, $depth = 1)
    {
        $keys = array_keys($sample);

        $isArray = false;
        foreach ($keys as $key) {
            if (is_integer($key)) {
                $isArray = true;
                break;
            }
        }

        if ($isArray) {
            $this->fifo[] = "<span style=\"color:black\">[</span>";
            $this->lifo[] = "<span style=\"color:black\">]</span>";
            foreach ($sample as $value) {
                $this->analyze($value, $depth + 1);
            }
        } else {
            $this->fifo[] = str_repeat(' ', 4 * ($depth - 1)) . "<span style=\"color:black\">{</span>";
            foreach ($sample as $key => $value) {
                $color = is_string($value) ? 'green' : (is_bool($value) ? 'red' : 'blue');
                $value = is_string($value) ? "\"$value\"" : (is_bool($value) ? ($value ? 'true' : 'false') : $value);
                $this->fifo[] = str_repeat(' ', 4 * $depth) . "<span style=\"color:black\">$key</span>: <span style=\"color:$color\">$value</span>";
            }
            $this->lifo[] = str_repeat(' ', 4 * ($depth - 1)) . "<span style=\"color:black\">}</span>";
        }
    }
}
