<?php

namespace Aternos\Sherlock\Maps;

use Aternos\Sherlock\MappedData\MappedClass;
use Aternos\Sherlock\MappedData\MappedMethod;

abstract class ObfuscationMap
{
    /**
     * @var string map content
     */
    protected string $content;

    /**
     * original name -> class
     * @var MappedClass[]
     */
    protected array $unmappedClasses;

    /**
     * mapped name -> class
     * @var MappedClass[]
     */
    protected array $mappedClasses;

    /**
     * @param $content string obfuscation map content
     * @throws \Exception
     */
    public function __construct(string $content) {
        $this->content = $content;
        $this->parseMappings();
    }

    /**
     * parse mappings for future use
     * @return void
     * @throws \Exception
     */
    protected abstract function parseMappings(): void;

    /**
     * get a class
     * first tries assumes the name is unmapped then falls back to a mapped name
     * @param string $name
     * @return MappedClass|null
     */
    public function getClass(string $name): ?MappedClass
    {
        $class = $this->unmappedClasses[$name];
        if (!isset($class)) {
            $class = $this->mappedClasses[$name];
        }
        return $class ?? null;
    }

    /**
     * get a method from a class
     * uses {{@link getClass}} to get the class by name and then finds the method using the name and line
     * @param string $className
     * @param string $name
     * @param int $line
     * @return MappedMethod|null
     */
    public function getMethod(string $className, string $name, int $line): ?MappedMethod
    {
        return $this->getClass($className)->getMethod($name, $line);
    }
}