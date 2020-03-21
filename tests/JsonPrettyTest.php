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
<pre><span style="color:black">[</span>
<span style="color:black">]</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
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

        $this->assertEquals($output, JsonPretty::print($sample));
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

        $this->assertEquals($output, JsonPretty::print($sample));
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

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_object_with_many_keys_and_numbers()
    {
        $sample = ['a' => 1, 'b' => 2];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:blue">1</span>,
    <span style="color:black">b</span>: <span style="color:blue">2</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
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

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_object_with_mixed_values_string_and_number()
    {
        $sample = ['a' => 'foo', 'b' => 2];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:green">"foo"</span>,
    <span style="color:black">b</span>: <span style="color:blue">2</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_that_contains_an_object_with_one_key_value()
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

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_with_strings()
    {
        $sample = ['a', 'b', 'c'];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:green">"a"</span>,
    <span style="color:green">"b"</span>,
    <span style="color:green">"c"</span>
<span style="color:black">]</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_of_numbers()
    {
        $sample = [1, 2, 3];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:blue">1</span>,
    <span style="color:blue">2</span>,
    <span style="color:blue">3</span>
<span style="color:black">]</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_with_key_and_null_as_value()
    {
        $sample = [
            'a' => null
        ];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:rebeccapurple">null</span>
<span style="color:black">}</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_nested_array_with_numbers()
    {
        $sample = [
            'a' => [1,2,3]
        ];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:black">[</span>
        <span style="color:blue">1</span>,
        <span style="color:blue">2</span>,
        <span style="color:blue">3</span>
    <span style="color:black">]</span>
<span style="color:black">}</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_nested_array_with_strings()
    {
        $sample = [
            'a' => ['b','c','d']
        ];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:black">[</span>
        <span style="color:green">"b"</span>,
        <span style="color:green">"c"</span>,
        <span style="color:green">"d"</span>
    <span style="color:black">]</span>
<span style="color:black">}</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_object_with_nested_array_of_objects()
    {
        $sample = [
            'name' => 'Axl Rose',
            'recipients' => [
                ['email' => null, 'first_name' => 'Slash', 'default' => false, 'cost' => 30.5],
                ['email' => 'duff@gnr.com', 'first_name' => 'Duff', 'default' => true, 'cost' => 28.5],
            ],
            'tokens' => [
                ['name' => 'Client.Phone', 'value' => ''],
                ['name' => 'Client.Title', 'value' => 'Owner']
            ]
        ];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">name</span>: <span style="color:green">"Axl Rose"</span>,
    <span style="color:black">recipients</span>: <span style="color:black">[</span>
        <span style="color:black">{</span>
            <span style="color:black">email</span>: <span style="color:rebeccapurple">null</span>,
            <span style="color:black">first_name</span>: <span style="color:green">"Slash"</span>,
            <span style="color:black">default</span>: <span style="color:red">false</span>,
            <span style="color:black">cost</span>: <span style="color:blue">30.5</span>
        <span style="color:black">}</span>,
        <span style="color:black">{</span>
            <span style="color:black">email</span>: <span style="color:green">"duff@gnr.com"</span>,
            <span style="color:black">first_name</span>: <span style="color:green">"Duff"</span>,
            <span style="color:black">default</span>: <span style="color:red">true</span>,
            <span style="color:black">cost</span>: <span style="color:blue">28.5</span>
        <span style="color:black">}</span>
    <span style="color:black">]</span>,
    <span style="color:black">tokens</span>: <span style="color:black">[</span>
        <span style="color:black">{</span>
            <span style="color:black">name</span>: <span style="color:green">"Client.Phone"</span>,
            <span style="color:black">value</span>: <span style="color:green">""</span>
        <span style="color:black">}</span>,
        <span style="color:black">{</span>
            <span style="color:black">name</span>: <span style="color:green">"Client.Title"</span>,
            <span style="color:black">value</span>: <span style="color:green">"Owner"</span>
        <span style="color:black">}</span>
    <span style="color:black">]</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_an_object_class()
    {
        $sample = new \Stdclass;
        $sample->a = 1;

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">a</span>: <span style="color:blue">1</span>
<span style="color:black">}</span></pre>
EOL;

        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_with_string_that_contains_commas()
    {
        $sample = ["khgkh, mitch, Delaware 234234"];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:green">"khgkh, mitch, Delaware 234234"</span>
<span style="color:black">]</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_object_that_contains_array_of_objects_that_contain_a_string_property_with_commas()
    {
        $sample = [
            'tokens' => [
                [
                    'name' => 'a',
                    'value' => 'string, with, commas'
                ]
            ]
        ];

        $output = <<<EOL
<pre><span style="color:black">{</span>
    <span style="color:black">tokens</span>: <span style="color:black">[</span>
        <span style="color:black">{</span>
            <span style="color:black">name</span>: <span style="color:green">"a"</span>,
            <span style="color:black">value</span>: <span style="color:green">"string, with, commas"</span>
        <span style="color:black">}</span>
    <span style="color:black">]</span>
<span style="color:black">}</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_of_booleans()
    {
        $sample = [
            true,
            false,
            true
        ];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:red">true</span>,
    <span style="color:red">false</span>,
    <span style="color:red">true</span>
<span style="color:black">]</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_mixed_array()
    {
        $sample = [
            1,
            true,
            "hey"
        ];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:blue">1</span>,
    <span style="color:red">true</span>,
    <span style="color:green">"hey"</span>
<span style="color:black">]</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }

    /** @test */
    function format_array_of_empty_arrays()
    {
        $sample = [[],[],[]];

        $output = <<<EOL
<pre><span style="color:black">[</span>
    <span style="color:black">[</span>
    <span style="color:black">]</span>,
    <span style="color:black">[</span>
    <span style="color:black">]</span>,
    <span style="color:black">[</span>
    <span style="color:black">]</span>
<span style="color:black">]</span></pre>
EOL;
        $this->assertEquals($output, JsonPretty::print($sample));
    }
}
