<?php

namespace Novosti\Repository\Common;

use Novosti\Repository\Traits\NovostiRepositoryTrait;
use Medoo\Medoo;

class CommonRepository
{

    use NovostiRepositoryTrait;

    /**
     * @var $conn
     */
    protected $conn;

    function __construct()
    {
        $this->connect();
    }

    /**
     * Make connection to database
     *
     * @return bool 
     */
    public function connect()
    {
        $this->conn = new Medoo(
            $this->getDatabaseConfig()
        );

        return true;
    }

}
