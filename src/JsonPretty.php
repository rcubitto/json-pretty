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
        $sample = $this->jsonEncodeAsArray($sample);

        foreach ($sample as $line) {
            // empty array
            preg_match('/^(\s*)\[](,?)$/', $line, $matches);
            if ($matches) {
                $indent = $matches[1] ?? '';
                $comma = $matches[2] ?? '';
                $this->lines[] = $indent . '<span style="color:black">[</span>';
                $this->lines[] = $indent . '<span style="color:black">]</span>' . $comma;
                continue;
            }

            // opening object
            if (ltrim($line, ' ') === '{') {
                $this->lines[] = str_replace('{', '<span style="color:black">{</span>', $line);
                continue;
            }

            // closing object
            preg_match('/^(})(,)*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $comma = $matches[2] ?? null;
                $this->lines[] = str_replace($value, "<span style=\"color:black\">{$value}</span>{$comma}", rtrim($line, ','));
                continue;
            }

            // opening array
            if (ltrim($line, ' ') === '[') {
                $this->lines[] = str_replace('[', '<span style="color:black">[</span>', $line);
                continue;
            }

            // closing array
            preg_match('/^(])(,)*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $comma = $matches[2] ?? null;
                $this->lines[] = str_replace($value, "<span style=\"color:black\">{$value}</span>{$comma}", rtrim($line, ','));
                continue;
            }

            // number
            preg_match('/^([\d.]*)[,]*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace("$value", "<span style=\"color:blue\">$value</span>", $line);
                continue;
            }

            // string
            preg_match('/^"([^:]*)"[,]*$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace("\"$value\"", "<span style=\"color:green\">\"$value\"</span>", $line);
                continue;
            }

            // boolean
            preg_match('/^(true|false)(?:,)?$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace($value, "<span style=\"color:red\">$value</span>", $line);
                continue;
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
            $this->lines[] = str_replace($value, "<span style=\"color:$valueColor\">$value</span>${comma}", $line); // value
            continue;
        }

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

    private function jsonEncodeAsArray($sample)
    {
        return explode("\n", json_encode((array) $sample, JSON_PRETTY_PRINT));
    }
}
