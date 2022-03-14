<?php

namespace Aternos\Sherlock\MappedData;

class MappedField
{
    private ?MappedClass $class;
    private string $name;
    private string $unmappedName;

    /**
     * @param MappedClass|null $class
     * @param string $name
     * @param string $unmappedName
     */
    public function __construct(?MappedClass $class, string $name, string $unmappedName)
    {
        $this->class = $class;
        $this->name = $name;
        $this->unmappedName = $unmappedName;
    }

    /**
     * @return MappedClass|null
     */
    public function getClass(): ?MappedClass
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName(): string
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
}