<?php

namespace Rcubitto\JsonPretty;

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
        // check if starting sample it is an array or an object
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
        } else {
            $this->fifo[] = "<span style=\"color:black\">{</span>";
            foreach ($sample as $key => $value) {
                $color = is_string($value) ? 'green' : 'blue';
                $value = is_string($value) ? "\"$value\"" : $value;
                $this->fifo[] = str_repeat(' ', 4) . "<span style=\"color:black\">$key</span>: <span style=\"color:$color\">$value</span>";
            }
            $this->lifo[] = "<span style=\"color:black\">}</span>";
        }

        // keep on going!



        return $this->build();
    }

    private function build()
    {
        return "<pre>" .
            implode(PHP_EOL, $this->fifo) .
            ((count($this->lifo) === 1 && count($this->fifo) === 1) ? '' : PHP_EOL) .
            implode(PHP_EOL, array_reverse($this->lifo))
        . "</pre>";
    }
}
