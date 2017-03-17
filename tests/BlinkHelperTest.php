<?php

namespace Spatie\LaravelBlink\Test;

use Spatie\Blink\Blink;

class BlinkHelperTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_blink()
    {
        $this->assertInstanceOf(Blink::class, blink());
    }

    /** @test */
    public function when_passing_a_single_argument_it_will_be_used_as_a_key()
    {
        blink()->put('key', 'myValue');

        $this->assertEquals('myValue', blink('key'));
    }

    /** @test */
    public function when_passing_a_two_arguments_they_will_be_used_to_put_something_in_the_blink_cache()
    {
        blink('key', 'myValue');

        $this->assertEquals('myValue', blink()->get('key'));
    }
}