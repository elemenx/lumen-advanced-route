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
            \Illuminate\Contracts\Foundation\Application::class => 'app',
            \Illuminate\Contracts\Auth\Factory::class => 'auth',
            \Illuminate\Contracts\Auth\Guard::class => 'auth.driver',
            \Illuminate\Contracts\Cache\Factory::class => 'cache',
            \Illuminate\Contracts\Cache\Repository::class => 'cache.store',
            \Illuminate\Contracts\Config\Repository::class => 'config',
            \Illuminate\Container\Container::class => 'app',
            \Illuminate\Contracts\Container\Container::class => 'app',
            \Illuminate\Database\ConnectionResolverInterface::class => 'db',
            \Illuminate\Database\DatabaseManager::class => 'db',
            \Illuminate\Contracts\Encryption\Encrypter::class => 'encrypter',
            \Illuminate\Contracts\Events\Dispatcher::class => 'events',
            \Illuminate\Contracts\Filesystem\Factory::class => 'filesystem',
            \Illuminate\Contracts\Filesystem\Filesystem::class => 'filesystem.disk',
            \Illuminate\Contracts\Filesystem\Cloud::class => 'filesystem.cloud',
            \Illuminate\Contracts\Hashing\Hasher::class => 'hash',
            'log' => \Psr\Log\LoggerInterface::class,
            \Illuminate\Contracts\Queue\Factory::class => 'queue',
            \Illuminate\Contracts\Queue\Queue::class => 'queue.connection',
            \Illuminate\Redis\RedisManager::class => 'redis',
            \Illuminate\Contracts\Redis\Factory::class => 'redis',
            \Illuminate\Redis\Connections\Connection::class => 'redis.connection',
            \Illuminate\Contracts\Redis\Connection::class => 'redis.connection',
            'request' => \Illuminate\Http\Request::class,
            \ElemenX\AdvancedRoute\Routing\Router::class => 'router',
            \Illuminate\Contracts\Translation\Translator::class => 'translator',
            \Laravel\Lumen\Routing\UrlGenerator::class => 'url',
            \Illuminate\Contracts\Validation\Factory::class => 'validator',
            \Illuminate\Contracts\View\Factory::class => 'view',
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
