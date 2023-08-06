<?php

namespace Jsl\Common\Views;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface as PlatesExtensionInterface;
use League\Plates\Template\Template;

class Views implements ViewsInterface
{
    /**
     * @var Engine
     */
    protected Engine $engine;


    /**
     * @param Engine $engine
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }


    /**
     * Set the default folder
     *
     * @param string $path
     *
     * @return self
     */
    public function setDefaultFolder(string $path): self
    {
        $this->engine->setDirectory($path);
        return $this;
    }


    /**
     * Get the default folder
     *
     * @return self
     */
    public function getDefaultFolder(): string
    {
        return $this->engine->getDirectory();
    }


    /**
     * Check if a folder has been added
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFolder(string $name): bool
    {
        return $this->engine->getFolders()->exists($name);
    }


    /**
     * Add a new template folder for grouping templates under different namespaces
     *
     * @param string $name
     * @param string $folder
     * @param bool $fallback
     *
     * @return self
     */
    public function addFolder(string $name, string $folder, bool $fallback = false): self
    {
        $this->engine->addFolder($name, $folder, $fallback);
        return $this;
    }


    /**
     * Remove a folder
     *
     * @param string $name
     *
     * @return self
     */
    public function dropFolder(string $name): self
    {
        $this->engine->removeFolder($name);
        return $this;
    }


    /**
     * Add global data (available in all templates)
     *
     * @param array $data
     *
     * @return self
     */
    public function addGlobalData(array $data): self
    {
        $this->engine->addData($data);
        return $this;
    }


    /**
     * Add preassigned template data.
     *
     * @param array $data
     * @param string|array $templates
     *
     * @return ViewsInterface
     */
    public function addTemplateData(array $data, string|array $templates): ViewsInterface
    {
        $this->engine->addData($data, $templates);
        return $this;
    }


    /**
     * Get added data
     *
     * @param array $templates Omit this to get all
     *
     * @return array
     */
    public function getData(string|array $templates = []): array
    {
        return $this->engine->getData($templates ?: null) ?? [];
    }


    /**
     * Check if a template function has been added
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFunction(string $name): bool
    {
        return $this->engine->doesFunctionExist($name);
    }


    /**
     * Add a template function
     *
     * @param string $name
     * @param callable $function
     *
     * @return self
     */
    public function addFunction(string $name, callable $function): self
    {
        $this->engine->registerFunction($name, $function);
        return $this;
    }


    /**
     * Get an added function
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getFunction(string $name): mixed
    {
        return $this->engine->getFunction($name);
    }


    /**
     * Remove a template function
     *
     * @param string $name
     *
     * @return self
     */
    public function dropFunction(string $name): self
    {
        $this->engine->dropFunction($name);
        return $this;
    }


    /**
     * Replace a function
     *
     * @param string $name
     * @param callable $function
     *
     * @return self
     */
    public function replaceFunction(string $name, callable $function): self
    {
        $this->dropFunction($name);
        $this->addFunction($name, $function);
        return $this;
    }


    /**
     * Register an extension
     *
     * @param ExtensionInterface|PlatesExtensionInterface $extension
     *
     * @return self
     */
    public function addExtension(ExtensionInterface|PlatesExtensionInterface $extension): self
    {
        hasInterface($extension, PlatesExtensionInterface::class)
            ? $this->engine->loadExtension($extension)
            : $extension->register($this);

        return $this;
    }


    /**
     * Batch add extensions
     *
     * @param array<ExtensionInterface|PlatesExtensionInterface> $extensions
     *
     * @return self
     */
    public function addExtensions(array $extensions): self
    {
        array_map([$this, 'addExtension'], $extensions);
        return $this;
    }


    /**
     * Check if a template exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasTemplate(string $name): bool
    {
        return $this->engine->exists($name);
    }


    /**
     * Get the path to a specific template
     *
     * @param string $name
     *
     * @return string
     */
    public function getTemplatePath(string $name): string
    {
        return $this->engine->path($name);
    }


    /**
     * Create a new template
     *
     * @param string $name
     * @param array $data
     *
     * @return Template
     */
    public function createTemplate(string $name, array $data = []): Template
    {
        return $this->engine->make($name, $data);
    }


    /**
     * Render a template
     *
     * @param string $name
     * @param array $data
     *
     * @return string
     */
    public function render(string $name, array $data = []): string
    {
        return $this->engine->render($name, $data);
    }
}
