<?php

namespace Novosti\Repository\Traits;

trait NovostiRepositoryTrait
{

    /**
     * Configuration for database storage
     */
    public function getDatabaseConfig()
    {
        return [
            'database_type' => 'sqlite',
            'database_file' => getenv('DATABASE_FILE'),
            'server' => 'localhost',
            'username' => '',
            'password' => ''
        ];
    }

}
