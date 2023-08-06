<?php

namespace Jsl\Common\Views;

use League\Plates\Extension\ExtensionInterface as PlatesExtensionInterface;
use League\Plates\Template\Template;

interface ViewsInterface
{
    /**
     * Set the default folder
     *
     * @param string $path
     *
     * @return self
     */
    public function setDefaultFolder(string $path): self;


    /**
     * Get the default folder
     *
     * @return self
     */
    public function getDefaultFolder(): string;


    /**
     * Check if a folder has been added
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFolder(string $name): bool;


    /**
     * Add a new template folder for grouping templates under different namespaces
     *
     * @param string $name
     * @param string $folder
     * @param bool $fallback
     *
     * @return self
     */
    public function addFolder(string $name, string $folder, bool $fallback = false): self;


    /**
     * Remove a folder
     *
     * @param string $name
     *
     * @return self
     */
    public function dropFolder(string $name): self;


    /**
     * Add global data (available in all templates)
     *
     * @param array $data
     *
     * @return self
     */
    public function addGlobalData(array $data): self;


    /**
     * Add preassigned template data.
     *
     * @param array $data
     * @param string|array $templates
     *
     * @return ViewsInterface
     */
    public function addTemplateData(array $data, string|array $templates): ViewsInterface;


    /**
     * Get added data
     *
     * @param array $templates Omit this to get all
     *
     * @return array
     */
    public function getData(string|array $templates = []): array;


    /**
     * Check if a template function has been added
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFunction(string $name): bool;


    /**
     * Add a template function
     *
     * @param string $name
     * @param callable $function
     *
     * @return self
     */
    public function addFunction(string $name, callable $function): self;


    /**
     * Get an added function
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getFunction(string $name): mixed;


    /**
     * Remove a template function
     *
     * @param string $name
     *
     * @return self
     */
    public function dropFunction(string $name): self;


    /**
     * Replace a function
     *
     * @param string $name
     * @param callable $function
     *
     * @return self
     */
    public function replaceFunction(string $name, callable $function): self;


    /**
     * Register an extension
     *
     * @param ExtensionInterface|PlatesExtensionInterface $extension
     *
     * @return self
     */
    public function addExtension(ExtensionInterface|PlatesExtensionInterface $extension): self;


    /**
     * Batch add extensions
     *
     * @param array<ExtensionInterface|PlatesExtensionInterface> $extensions
     *
     * @return self
     */
    public function addExtensions(array $extensions): self;


    /**
     * Check if a template exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasTemplate(string $name): bool;


    /**
     * Get the path to a specific template
     *
     * @param string $name
     *
     * @return string
     */
    public function getTemplatePath(string $name): string;


    /**
     * Create a new template
     *
     * @param string $name
     * @param array $data
     *
     * @return Template
     */
    public function createTemplate(string $name, array $data = []): Template;


    /**
     * Render a template
     *
     * @param string $name
     * @param array $data
     *
     * @return string
     */
    public function render(string $name, array $data = []): string;
}
