<?php

namespace Gogordos\Framework\Config;


use Gogordos\Framework\Slim\Config;

class CurrentVersion
{
    /** @var Config */
    private $config;

    /** @var   */
    private $logger;

    public function __construct(Config $config, $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function get()
    {
        try {
            $version = file_get_contents(__DIR__ . '/../../../' . $this->config->get('current_version_file'));
        } catch (\Exception $e) {
            $this->logger->error('Error trying to obtain current version. Error: ' . $e->getMessage());
            $version = 'unknown_version';
        }
        
        return $version;
    }
}
