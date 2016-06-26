<?php

namespace Gogordos\Application\Commands;

class DummyHandle implements Handler
{
    public function handle($command)
    {
        // Here is where the command makes something. Maybe you need to inject a service in the constructor and
        // call it here.

        // If you need to return something, don't put it on a command, put it in a service!
    }
}
