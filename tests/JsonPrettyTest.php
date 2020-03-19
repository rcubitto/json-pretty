<?php

namespace Rcubitto\JsonPretty\Tests;

use PHPUnit\Framework\TestCase;
use Rcubitto\JsonPretty\JsonPretty;

class JsonPrettyTest extends TestCase
{
    /** @test */
    function format_empty_array()
    {
        $sample = [];
        $output = '<pre><span style="color:black">{</span><span style="color:black">}</span></pre>';

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_one_key_and_number()
    {
        $sample = ['a' => 1];

        $output = '<pre>';
        $output .= '<span style="color:black">{</span>' . PHP_EOL;
        $output .= '    <span style="color:black">a</span>: <span style="color:blue">1</span>' . PHP_EOL;
        $output .= '<span style="color:black">}</span>';
        $output .= '</pre>';

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_many_keys_and_numbers()
    {
        $sample = ['a' => 1, 'b' => 2];

        $output = '<pre>';
        $output .= '<span style="color:black">{</span>' . PHP_EOL;
        $output .= '    <span style="color:black">a</span>: <span style="color:blue">1</span>' . PHP_EOL;
        $output .= '    <span style="color:black">b</span>: <span style="color:blue">2</span>' . PHP_EOL;
        $output .= '<span style="color:black">}</span>';
        $output .= '</pre>';

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_key_and_string()
    {
        $sample = ['a' => 'foo'];

        $output = '<pre>';
        $output .= '<span style="color:black">{</span>' . PHP_EOL;
        $output .= '    <span style="color:black">a</span>: <span style="color:green">"foo"</span>' . PHP_EOL;
        $output .= '<span style="color:black">}</span>';
        $output .= '</pre>';

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_mixed_values_string_and_number()
    {
        $sample = ['a' => 'foo', 'b' => 2];

        $output = '<pre>';
        $output .= '<span style="color:black">{</span>' . PHP_EOL;
        $output .= '    <span style="color:black">a</span>: <span style="color:green">"foo"</span>' . PHP_EOL;
        $output .= '    <span style="color:black">b</span>: <span style="color:blue">2</span>' . PHP_EOL;
        $output .= '<span style="color:black">}</span>';
        $output .= '</pre>';

        $this->assertEquals($output, JsonPretty::format($sample));
    }
}
