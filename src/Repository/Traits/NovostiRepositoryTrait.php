<?php

namespace Novosti\Repository\Traits;

trait NovostiRepositoryTrait
{

    /**
     * Configuration for database storage
     */
    public $databaseConfig = [
        'database_type' => 'sqlite',
        'database_file' => '/Users/dns/dev/novosti/database/novosti.sqlite',
        'server' => 'localhost',
        'username' => '',
        'password' => ''
    ];

}
