<?php

namespace Gogordos\Domain\Entities;

class Category implements \JsonSerializable
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;
    
    /** @var string */
    private $nameEs;

    /**
     * Category constructor.
     * @param int $id
     * @param string $name
     * @param $nameEs
     */
    public function __construct($id, $name, $nameEs)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nameEs = $nameEs;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function nameEs()
    {
        return $this->nameEs;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'nameEs' => $this->nameEs
        ];
    }
}
