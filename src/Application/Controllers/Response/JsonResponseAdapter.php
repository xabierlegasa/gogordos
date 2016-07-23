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
            /** array_unshift_assoc will make that status is the first thing in the array **/
            $this->array_unshift_assoc($this->data, 'status', StatusCode::STATUS_SUCCESS);
        } else {
            $this->array_unshift_assoc($this->data, 'status', StatusCode::STATUS_ERROR);
        }

        return $this->data;
    }

    private function array_unshift_assoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr = array_reverse($arr, true);

        return $arr;
    }
}
