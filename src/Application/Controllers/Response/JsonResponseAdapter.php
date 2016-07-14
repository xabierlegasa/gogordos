<?php

namespace Gogordos\Application\Controllers\Response;

use Gogordos\Application\StatusCode;

abstract class JsonResponseAdapter implements JsonResponse
{
    /** @var array */
    protected $data;

    /** @var int */
    protected $httpCode;

    public function httpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return array
     */
    public function data()
    {
        if ($this->httpCode === 200) {
            $this->data['status'] = StatusCode::STATUS_SUCCESS;
        } else {
            $this->data['status'] = StatusCode::STATUS_ERROR;
        }

        return $this->data;
    }
}
