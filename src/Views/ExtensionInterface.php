<?php

namespace Jsl\Common\Views;

interface ExtensionInterface
{
    /**
     * @param ViewsInterface $views
     *
     * @return void
     */
    public function register(ViewsInterface $views): void;
}
