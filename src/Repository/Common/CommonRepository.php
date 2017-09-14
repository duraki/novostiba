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

    /**
     * Make connection to database
     *
     * @return bool 
     */
    public function makeConnection()
    {
        $this->conn = new Medoo(
            $this->databaseConfig
        );

        return true;
    }

}
