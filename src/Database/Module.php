<?php

namespace Jsl\Common\Database;

use Exception;
use Jsl\Database\ConnectionInterface;
use Jsl\Database\ConnectionResolver;
use Jsl\Database\ConnectionResolverInterface;
use Jsl\Kernel\Kernel;
use Jsl\Kernel\Modules\AbstractModule;
use Jsl\Models\Models;

class Module extends AbstractModule
{
    /**
     * @inheritDoc
     */
    public function id(): string
    {
        return 'database';
    }


    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Database (jsl/database & jsl/models)';
    }


    /**
     * @inheritDoc
     */
    public function boot(Kernel $kernel): void
    {
        // Bind the connection resolver and add all configured connections
        $kernel->bind(ConnectionResolverInterface::class, function () use ($kernel) {
            $connections = $kernel->config->get('database.connections', []);
            $default = $kernel->config->get('database.default', '');

            if (empty($connections)) {
                throw new Exception("Not database connections configured");
            }

            $resolver = new ConnectionResolver($connections);;

            if ($default) {
                $resolver->setDefaultConnection($default);
            }

            return $resolver;
        });

        // Bind the default connection to the container
        $kernel->bind(ConnectionInterface::class, function () use ($kernel) {
            $default = $kernel->config->get('database.default', '');
            $resolver = $kernel->get(ConnectionResolverInterface::class);

            if (empty($default) || $resolver->hasConnection($default) === false) {
                throw new Exception("No default database connection configured");
            }

            return $resolver->connection($default);
        });

        // Pass the default connection to the models
        Models::setConnection(fn () => $kernel->get(ConnectionInterface::class));
    }


    /**
     * @inheritDoc
     */
    public function config(): array
    {
        return [
            'default' => 'default',
            'connections' => [],
        ];
    }
}
