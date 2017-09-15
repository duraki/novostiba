<?php

namespace Novosti\Common;

use Monolog\Logger as LoggerInterface;
use Monolog\Handler\StreamHandler;

class Writer {

    static function writeDataToFile($data, $file)
    {
        $fh = fopen($file, "w+");
        fwrite($fh, $data);
        fclose($fh); 
    }

}
