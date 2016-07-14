<?php

namespace Gogordos\Application\Controllers\Response;

interface JsonResponse
{
    /**
     * @return int
     */
    public function httpCode();

    /**
     * @return array
     */
    public function data();
}