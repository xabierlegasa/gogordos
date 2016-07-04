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

            if (strlen($version) === 15) {
                $version = substr($version, 0, 4)
                    . '-' . substr($version, 4, 2)
                    . '-' . substr($version, 6, 2)
                    . ' ' . substr($version, 8, 2)
                    . ':' . substr($version, 10, 2)
                    . ' - ' . substr($version, 12, 3)
                ;
            }
        } catch (\Exception $e) {
            $this->logger->error('Error trying to obtain current version. Error: ' . $e->getMessage());
            $version = 'unknown_version';
        }

        return $version;
    }
}
