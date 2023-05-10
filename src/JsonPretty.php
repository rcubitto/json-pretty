<?php

namespace Rcubitto\JsonPretty;

class JsonPretty
{
    protected $lines = [];

    protected $options = [];

    public static function print($sample, $options = [])
    {
        return (new self)
            ->options($options)
            ->parse($sample)
            ->toString();
    }

    public function options(array $options)
    {
        $defaults = [
            'colors' => [
                'key' => 'brown',
                'bracket' => 'black',
                'number' => 'blue',
                'string' => 'green',
                'boolean' => 'red',
                'null' => 'rebeccapurple'
            ]
        ];

        $this->options = array_replace_recursive($defaults, $options);

        return $this;
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
                $this->lines[] = $indent . "<span style=\"color:{$this->color('[')}\">[</span>";
                $this->lines[] = $indent . "<span style=\"color:{$this->color(']')}\">]</span>" . $comma;
                continue;
            }

            // opening object
            if (ltrim($line, ' ') === '{') {
                $this->lines[] = str_replace('{', "<span style=\"color:{$this->color('{')}\">{</span>", $line);
                continue;
            }

            // closing object
            if (ltrim(rtrim($line, ','), ' ') === '}') {
                $this->lines[] = str_replace('}', "<span style=\"color:{$this->color('}')}\">}</span>", $line);
                continue;
            }

            // opening array
            if (ltrim($line, ' ') === '[') {
                $this->lines[] = str_replace('[', "<span style=\"color:{$this->color('[')}\">[</span>", $line);
                continue;
            }

            // closing array
            if (ltrim(rtrim($line, ','), ' ') === ']') {
                $this->lines[] = str_replace(']', "<span style=\"color:{$this->color(']')}\">]</span>", $line);
                continue;
            }

            // number
            preg_match('/^(\d+\.?\d*)(?:,)?$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace("$value", "<span style=\"color:{$this->color($value)}\">$value</span>", $line);
                continue;
            }

            // string
            preg_match('/^"([^\"]+)"(?:,)?$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace("\"$value\"", "<span style=\"color:{$this->color($value)}\">\"$value\"</span>", $line);
                continue;
            }

            // boolean
            preg_match('/^(true|false)(?:,)?$/', ltrim($line, ' '), $matches);
            if ($matches) {
                $value = $matches[1];
                $this->lines[] = str_replace($value, "<span style=\"color:{$this->color($value)}\">$value</span>", $line);
                continue;
            }

            // key / value
            preg_match('/^"(.+)":\s(.+)$/', ltrim($line, ' '), $matches);
            $key = $matches[1];

            if (strlen($matches[2]) > 1) {
                list($value, $comma) = str_split($matches[2], strlen($matches[2]) - 1);
                if ($comma !== ',') {
                    $value = $matches[2];
                }
            } else {
                $value = $matches[2];
            }

            $line = str_replace("\"$key\"", "<span style=\"color:{$this->color($key)}\">$key</span>", $line); // key
            $this->lines[] = str_replace($value, "<span style=\"color:{$this->color($value)}\">$value</span>", $line); // value
            continue;
        }

        return $this;
    }

    private function color($string)
    {
        if ($string === 'true' || $string === 'false') return $this->options['colors']['boolean'];

        if ($string === 'null') return $this->options['colors']['null'];

        if (is_numeric($string)) return $this->options['colors']['number'];

        if (in_array($string, ['{', '}', '[', ']']) || $string === '[]' || $string === '{}') return $this->options['colors']['bracket'];

        if(strpos($string, '"') === 0) return $this->options['colors']['string'];

        if(substr($string, 0, 1) === '"') return $this->options['colors']['string'];

        return $this->options['colors']['key'];
    }

    private function jsonEncodeAsArray($sample)
    {
        return explode("\n", json_encode((array) $sample, JSON_PRETTY_PRINT));
    }
}
