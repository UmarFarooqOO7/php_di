<?php

namespace Tests\Events;

use PHPUnit\Framework\TestCase;
use App\Events\EventDispatcher;

class EventDispatcherTest extends TestCase
{
    private EventDispatcher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new EventDispatcher();
    }

    public function testCanAddListener(): void
    {
        $called = false;
        $testEvent = new class {};

        $this->dispatcher->listen(get_class($testEvent), function() use (&$called) {
            $called = true;
        });

        $this->dispatcher->dispatch($testEvent);
        $this->assertTrue($called);
    }

    public function testMultipleListenersAreCalled(): void
    {
        $count = 0;
        $testEvent = new class {};

        $this->dispatcher->listen(get_class($testEvent), function() use (&$count) {
            $count++;
        });

        $this->dispatcher->listen(get_class($testEvent), function() use (&$count) {
            $count++;
        });

        $this->dispatcher->dispatch($testEvent);
        $this->assertEquals(2, $count);
    }

    public function testListenerIsNotCalledForDifferentEvent(): void
    {
        $called = false;
        $testEvent1 = new class {};
        $testEvent2 = new class {};

        $this->dispatcher->listen(get_class($testEvent1), function() use (&$called) {
            $called = true;
        });

        $this->dispatcher->dispatch($testEvent2);
        $this->assertFalse($called);
    }
}
