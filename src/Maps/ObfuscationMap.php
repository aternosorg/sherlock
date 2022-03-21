<?php

namespace Aternos\Sherlock\Maps;

use Aternos\Sherlock\MappedData\MappedClass;
use Aternos\Sherlock\MappedData\MappedField;
use Aternos\Sherlock\MappedData\MappedMethod;

abstract class ObfuscationMap
{
    /**
     * original name -> class
     * @var MappedClass[]
     */
    protected array $unmappedClasses = [];

    /**
     * mapped name -> class
     * @var MappedClass[]
     */
    protected array $mappedClasses = [];

    /**
     * @param $content string obfuscation map content
     * @throws \Exception
     */
    public function __construct(protected string $content) {
        $this->parseMappings();
    }

    /**
     * parse mappings for future use
     * @return void
     * @throws \Exception
     */
    protected abstract function parseMappings(): void;

    /**
     * @return MappedClass[]
     */
    public function getMappedClasses(): array
    {
        return $this->mappedClasses;
    }

    /**
     * @return MappedClass[]
     */
    public function getUnmappedClasses(): array
    {
        return $this->unmappedClasses;
    }

    /**
     * get the raw obfuscation map content
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    protected function addClass(MappedClass $class): void
    {
        $this->unmappedClasses[$class->getUnmappedName()] = $class;
        $this->mappedClasses[$class->getPath()] = $class;
    }

    /**
     * get a class
     * first tries assumes the name is unmapped then falls back to a mapped name
     * @param string $name
     * @return MappedClass|null
     */
    public function getClass(string $name): ?MappedClass
    {
        $class = $this->unmappedClasses[$name] ?? null;
        if ($class === null) {
            $class = $this->mappedClasses[$name] ?? null;
        }
        return $class;
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

    /**
     * get a method from a class
     * uses {{@link getClass}} to get the class by name and then finds the field using the name
     * @param string $className
     * @param string $name
     * @return MappedField|null
     */
    public function getField(string $className, string $name): ?MappedField
    {
        return $this->getClass($className)->getField($name);
    }
}