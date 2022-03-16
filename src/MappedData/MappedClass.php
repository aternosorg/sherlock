<?php

namespace Aternos\Sherlock\MappedData;

class MappedClass
{
    protected string $name;
    protected string $package = "";
    /**
     * @var MappedMethod[]
     */
    protected array $methods;
    /**
     * @var MappedField[]
     */
    protected array $fields;

    public function __construct($mappedName, protected string $unmappedName)
    {
        preg_match("/^(?:(.*)\.)?([^.]+)$/", $mappedName, $matches);
        if (isset($matches[2])) {
            $this->package = $matches[1];
            $this->name = $matches[2];
        }
        else {
            $this->name = $matches[1];
        }
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
    public function getUnmappedName(): string
    {
        return $this->unmappedName;
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
     * get a method of this class by it's unmapped name and the line number
     * @param string $name unmapped name
     * @param int $line line number
     * @return MappedMethod|null
     */
    public function getMethod(string $name, int $line): ?MappedMethod
    {
        foreach ($this->methods as $method) {
            if ($method->getUnmappedName() === $name && $method->getStartLine() <= $line && $method->getEndLine() >= $line) {
                return $method;
            }
        }
        return null;
    }

    /**
     * add a new method to this class
     * @param MappedMethod $method
     * @return void
     */
    public function addMethod(MappedMethod $method): void
    {
        $this->methods[] = $method;
    }

    /**
     * @param $name string unmapped name
     * @return ?MappedField
     */
    public function getField(string $name): ?MappedField
    {
        return $this->fields[$name] ?? null;
    }

    /**
     * add a new field to this class
     * @param MappedField $field
     * @param string $key
     * @return void
     */
    public function addField(MappedField $field, string $key): void
    {
        $this->fields[$key] = $field;
    }
}