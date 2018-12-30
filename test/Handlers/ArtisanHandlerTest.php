<?php

namespace Intouch\LaravelAwsLambda\Test\Handlers;

use Intouch\LaravelAwsLambda\Test\TestCase;
use Intouch\LaravelAwsLambda\Handlers\Artisan;

class ArtisanHandlerTest extends TestCase
{
    public $validJson = '
    {
      "command": "inspire"
    }';

    /** @test */
    public function can_handle_a_valid_artisan_message()
    {
        $payload = json_decode($this->validJson, true);

        $handler = new Artisan($payload);
        $this->assertTrue($handler->canHandle());
    }

    /** @test */
    public function it_handles_an_artisan_message_correctly()
    {
        $kernel = \Mockery::mock('Illuminate\Foundation\Console\Kernel');
        $kernel->shouldReceive('call')->with('inspire')->once()->andReturn(0);
        $kernel->shouldReceive('terminate')->with(null, 0)->once();

        $payload = json_decode($this->validJson, true);

        $handler = new Artisan($payload);
        $handler->handle($kernel);
    }
}