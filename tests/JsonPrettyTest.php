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
        $output = <<<EOL
<pre><span style="color:black">{</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_one_key_and_number()
    {
        $sample = ['a' => 1];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:blue">1</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_one_key_and_true_value()
    {
        $sample = ['a' => true];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:red">true</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_one_key_and_false_value()
    {
        $sample = ['a' => false];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:red">false</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_many_keys_and_numbers()
    {
        $sample = ['a' => 1, 'b' => 2];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:blue">1</span>
    <span style="color:black">b</span>: <span style="color:blue">2</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_key_and_string()
    {
        $sample = ['a' => 'foo'];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:green">"foo"</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_object_with_mixed_values_string_and_number()
    {
        $sample = ['a' => 'foo', 'b' => 2];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:green">"foo"</span>
    <span style="color:black">b</span>: <span style="color:blue">2</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }

    /** @test */
    function format_array_that_contains_a_object_with_one_key_value()
    {
        $sample = [
            ['a' => 1]
        ];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:black">{</span>
        <span style="color:black">a</span>: <span style="color:blue">1</span>
    <span style="color:black">}</span>
<span style="color:black">]</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::format($sample));
    }
}
