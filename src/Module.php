<?php

namespace Jsl\Common;

use Jsl\Kernel\Kernel;
use Jsl\Kernel\Modules\AbstractModule;

class Module extends AbstractModule
{
    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Kernel Common';
    }


    /**
     * @inheritDoc
     */
    public function id(): ?string
    {
        return null;
    }


    /**
     * @inheritDoc
     */
    public function boot(Kernel $kernel): void
    {
        $kernel->addModules([
            Views\Module::class,
            Database\Module::class,
        ]);
    }
}
