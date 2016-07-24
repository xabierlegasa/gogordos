<?php

namespace Gogordos\Application\Controllers\Response;

class JsonInternalServerError extends JsonResponseAdapter
{
    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->httpCode = 500;
    }
}
