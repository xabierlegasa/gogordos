<?php

namespace Gogordos\Application\Commands;

interface Handler
{
    public function handle($command);
}