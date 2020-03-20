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
    protected $lines = [];

    public static function print($sample)
    {
        return (new self)->parse($sample)->toString();
    }

    private function toString()
    {
        return "<pre>" . implode(PHP_EOL, $this->lines) . "</pre>";
    }

    private function parse($sample)
    {
        $sample = $this->jsonEncode($sample);

        $this->lines = array_map(function ($line) {
            // opening object
            if (ltrim($line, ' ') === '{') return str_replace('{', '<span style="color:black">{</span>', $line);

            // closing object
            preg_match('/^(})(,)*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $comma = $matches[2] ?? null;
                return str_replace($value, "<span style=\"color:black\">{$value}</span>{$comma}", rtrim($line, ','));
            }

            // opening array
            if (ltrim($line, ' ') === '[') return str_replace('[', '<span style="color:black">[</span>', $line);

            // closing array
            preg_match('/^(])(,)*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $comma = $matches[2] ?? null;
                return str_replace($value, "<span style=\"color:black\">{$value}</span>{$comma}", rtrim($line, ','));
            }

            // number
            preg_match('/^([\d.]*)[,]*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                return str_replace("$value", "<span style=\"color:blue\">$value</span>", $line);
            }

            // string
            preg_match('/^"([^:]*)"[,]*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                return str_replace("\"$value\"", "<span style=\"color:green\">\"$value\"</span>", $line);
            }

            // boolean
            preg_match('/^(true|false)(?:,)?$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                return str_replace($value, "<span style=\"color:red\">$value</span>", $line);
            }

            // key / value
            preg_match('/^"(.+)":\s(.+)$/', ltrim($line, ' '), $matches);
            $key = $matches[1];

            if (strlen($matches[2]) > 1) {
                list($value, $comma) = str_split($matches[2], strlen($matches[2]) - 1);
                if ($comma !== ',') {
                    $value = $matches[2];
                    $comma = '';
                }
            } else {
                $value = $matches[2];
                $comma = '';
            }

            $line = str_replace("\"$key\"", "<span style=\"color:black\">$key</span>", rtrim($line, ',')); // key
            $valueColor = $this->color($value); // color
            return str_replace($value, "<span style=\"color:$valueColor\">$value</span>${comma}", $line); // value

        }, explode("\n", $sample));

        return $this;
    }

    private function color($string)
    {
        if ($string === 'true' || $string === 'false') return 'red';

        if ($string === 'null') return 'rebeccapurple';

        if (is_numeric($string)) return 'blue';

        if (in_array($string, ['{', '}', '[', ']'])) return 'black';

        return 'green'; // string
    }

    private function jsonEncode($sample)
    {
        return $sample === [] ? "[\n]" : json_encode((array) $sample, JSON_PRETTY_PRINT);
    }
}
