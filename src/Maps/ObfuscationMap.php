<?php

namespace Aternos\Sherlock\Maps;

use Aternos\Sherlock\MappedData\MappedClass;
use Aternos\Sherlock\MappedData\MappedMethod;

class ObfuscationMap
{
    private string $content;

    /**
     * @var MappedClass[]
     */
    private array $obfuscatedClasses;

    /**
     * @var MappedClass[]
     */
    private array $realClasses;

    public function __construct($content)
    {
        $this->content = $content;
        $this->readMappings();
    }

    /**
     * @throws \Exception
     */
    public function readMappings(): void
    {
        $class = null;
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
            if ($line === "" || str_starts_with($line, "#")) {
                continue;
            }

            if (preg_match("/^\s+/", $line)) {
                //methods of class
                if ($class === null) {
                    throw new \Exception("Method found before class!");
                }
                $class->handleFieldOrMethod($line);
                continue;
            }

            if (!preg_match("/^([^\s]+) -> ([^\s]+):$/", $line, $matches)) {
                throw new \Exception("Invalid class name found: " . $line);
            }

            $classPath = $matches[1];
            $obfuscatedName = $matches[2];
            $class = new MappedClass($classPath, $obfuscatedName);
            $this->obfuscatedClasses[$obfuscatedName] = $class;
            $this->realClasses[$classPath] = $class;
        }
    }

    public function getObfuscatedClasses(): array
    {
        return $this->obfuscatedClasses;
    }

    public function getClass(string $name): ?MappedClass
    {
        return $this->obfuscatedClasses[$name] ?? null;
    }

    public function getMethod(string $className, string $name, int $line): ?MappedMethod
    {
        $class = $this->obfuscatedClasses[$className];
        if (!isset($class)) {
            $class = $this->realClasses[$className];
        }
        return $class->getMethod($name, $line);
    }

}