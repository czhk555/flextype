<?php

declare(strict_types=1);

namespace Flextype\App\Foundation\Cache;

use Doctrine\Common\Cache\SQLite3Cache;
use Flextype\Component\Filesystem\Filesystem;
use Psr\Container\ContainerInterface;
use SQLite3;

class SQLite3CacheAdapter implements CacheAdapterInterface
{
    /**
     * Application
     *
     * @access private
     */
    private $flextype;
    
    public function __construct(ContainerInterface $flextype)
    {
        $this->flextype = $flextype;
    }

    public function getDriver() : object
    {
        $cache_directory = PATH['cache'] . '/doctrine/';

        if (! Filesystem::has($cache_directory)) {
            Filesystem::createDir($cache_directory);
        }

        $db = new SQLite3($cache_directory . $this->flextype->container('registry')->get('flextype.settings.cache.sqlite3.database', 'flextype') . '.db');

        return new SQLite3Cache($db, $this->flextype->container('registry')->get('flextype.settings.cache.sqlite3.table', 'flextype'));
    }
}
