<?php

namespace Gogordos\Framework\Slim;


class Config
{
    /** @var array */
    private $configs;
    
    public function __construct($configs = [])
    {
        $this->configs = $configs;
    }

    /**
     * @param string $configKey
     * @return string
     * @throws \Exception
     */
    public function get($configKey)
    {
        if (!array_key_exists($configKey, $this->configs)) {
            throw new \Exception('Config key not found. Key: ' . $configKey);
        }
        
        return $this->configs[$configKey];
    }
}
