<?php

namespace Jsl\Common\Views;

use Jsl\Kernel\Kernel;
use Jsl\Kernel\Modules\AbstractModule;
use League\Plates\Engine;

class Module extends AbstractModule
{
    /**
     * @inheritDoc
     */
    public function id(): string
    {
        return 'views';
    }


    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Views (league/plates)';
    }


    /**
     * @inheritDoc
     */
    public function boot(Kernel $kernel): void
    {
        $kernel->bind(ViewsInterface::class, function () use ($kernel) {
            $views = new Views(new Engine);

            $folders = $kernel->config->get('views.folders', []);
            foreach ($folders as $name => $path) {
                $name === 'default'
                    ? $views->setDefaultFolder($path)
                    : $views->addFolder($name, $path);
            }

            $views->addExtensions(
                $kernel->config->get('views.extensions', [])
            );

            return $views;
        });
    }
}
