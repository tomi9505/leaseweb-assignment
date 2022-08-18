<?php

namespace App\Entity;

use Exception;

class ServerList
{
    // This represents the instance
    private static $fileName;

    private function __construct() { }

    private function __clone() { }

    /**
     * @throws Exception
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getFileName(): ?string
    {
        return ServerList::$fileName;
    }

    public static function setFileName(string $fileName)
    {
        ServerList::$fileName = $fileName;
    }
}
