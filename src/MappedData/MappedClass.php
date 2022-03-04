<?php

namespace Aternos\Sherlock\MappedData;

class MappedClass
{
    private string $name;
    private string $package = "";
    private string $obfuscatedName;
    /**
     * @var MappedMethod[]
     */
    private array $methods;
    /**
     * @var MappedField[]
     */
    private array $fields;

    public function __construct($path, $obfuscatedName)
    {
        preg_match("/^(?:(.*)\.)?([^.]+)$/", $path, $matches);
        if (isset($matches[2])) {
            $this->package = $matches[1];
            $this->name = $matches[2];
        }
        else {
            $this->name = $matches[1];
        }

        $this->obfuscatedName = $obfuscatedName;
    }

    /**
     * @return mixed|string
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getObfuscatedName(): string
    {
        return $this->obfuscatedName;
    }

    /**
     * @return mixed|string
     */
    public function getPackage(): mixed
    {
        return $this->package;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        if ($this->package === "") {
            return $this->name;
        }
        else {
            return $this->package . "." . $this->name;
        }
    }

    /**
     * @param $line
     * @return void
     */
    public function handleFieldOrMethod($line): void
    {
        if (preg_match("/^\s+(\d+):(\d+):([^\s]+) ([^\s(]+)\s?\(([^)]*)\) -> ([^\s]+)$/", $line, $matches)) {
            $method = new MappedMethod($this, ...array_slice($matches, 1));
            $this->methods[] = $method;
        }
        else {
            if(!preg_match("/^\s+([^\s]+) ([^\s]+) -> ([^\s]+)$/", $line, $matches)) {
                throw new \Exception("Invalid field line: " . $line);
            }

            $field = new MappedField($this, ...array_slice($matches, 1));
            $this->fields[$field->getObfuscatedName()] = $field;
        }
    }

    /**
     * get a method of this class by it's obfuscated name and the line number
     * @param string $name obfuscated name
     * @param int $line line number
     * @return MappedMethod|null
     */
    public function getMethod(string $name, int $line): ?MappedMethod
    {
        foreach ($this->methods as $method) {
            if ($method->getObfuscatedName() === $name && $method->getStartLine() <= $line && $method->getEndLine() >= $line) {
                return $method;
            }
        }
        return null;
    }

    /**
     * @param $name string obfuscated name
     * @return ?MappedField
     */
    public function getField(string $name): ?MappedField
    {
        return $this->fields[$name] ?? null;
    }
}