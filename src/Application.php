<?php

namespace ElemenX\AdvancedRoute;

use ElemenX\AdvancedRoute\Routing\Router;

/**
 * Class Application
 */
class Application extends \Laravel\Lumen\Application
{
    /**
     * Register the core container aliases.
     *
     * @return void
     */
    protected function registerContainerAliases()
    {
        $this->aliases = [
            'Illuminate\Contracts\Foundation\Application' => 'app',
            'Illuminate\Contracts\Auth\Factory' => 'auth',
            'Illuminate\Contracts\Auth\Guard' => 'auth.driver',
            'Illuminate\Contracts\Cache\Factory' => 'cache',
            'Illuminate\Contracts\Cache\Repository' => 'cache.store',
            'Illuminate\Contracts\Config\Repository' => 'config',
            'Illuminate\Container\Container' => 'app',
            'Illuminate\Contracts\Container\Container' => 'app',
            'Illuminate\Database\ConnectionResolverInterface' => 'db',
            'Illuminate\Database\DatabaseManager' => 'db',
            'Illuminate\Contracts\Encryption\Encrypter' => 'encrypter',
            'Illuminate\Contracts\Events\Dispatcher' => 'events',
            'Illuminate\Contracts\Filesystem\Factory' => 'filesystem',
            'Illuminate\Contracts\Filesystem\Filesystem' => 'filesystem.disk',
            'Illuminate\Contracts\Filesystem\Cloud' => 'filesystem.cloud',
            'Illuminate\Contracts\Hashing\Hasher' => 'hash',
            'log' => 'Psr\Log\LoggerInterface',
            'Illuminate\Contracts\Queue\Factory' => 'queue',
            'Illuminate\Contracts\Queue\Queue' => 'queue.connection',
            'Illuminate\Redis\RedisManager' => 'redis',
            'Illuminate\Contracts\Redis\Factory' => 'redis',
            'Illuminate\Redis\Connections\Connection' => 'redis.connection',
            'Illuminate\Contracts\Redis\Connection' => 'redis.connection',
            'request' => 'Illuminate\Http\Request',
            'ElemenX\AdvancedRoute\Routing\Router' => 'router',
            'Illuminate\Contracts\Translation\Translator' => 'translator',
            'Laravel\Lumen\Routing\UrlGenerator' => 'url',
            'Illuminate\Contracts\Validation\Factory' => 'validator',
            'Illuminate\Contracts\View\Factory' => 'view',
        ];
    }

    /**
     * Bootstrap the router instance.
     *
     * @return void
     */
    public function bootstrapRouter()
    {
        $this->router = new Router($this);
    }
}
