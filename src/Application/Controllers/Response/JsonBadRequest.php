<?php

namespace Gogordos\Application\Controllers\Response;

class JsonBadRequest extends JsonResponseAdapter
{
    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->httpCode = 400;
    }
}
