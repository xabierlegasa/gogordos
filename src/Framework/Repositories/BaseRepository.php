<?php

namespace Gogordos\Framework\Repositories;


use Gogordos\Framework\Slim\Config;
use PDO;

class BaseRepository
{
    /** @var Config */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return PDO
     * @throws \Exception
     */
    protected function getConnection()
    {
        $connection = new PDO(
            'mysql:host=localhost;dbname=' . $this->config->get('mysql_database_name') . ';charset=utf8',
            $this->config->get('mysql_username'),
            $this->config->get('mysql_password')
        );

        return $connection;
    }
}
