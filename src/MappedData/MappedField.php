<?php

namespace Aternos\Sherlock\MappedData;

class MappedField
{
    /**
     * @param MappedClass|null $class
     * @param string $name
     * @param string $unmappedName
     */
    public function __construct(protected ?MappedClass $class, protected string $name, protected string $unmappedName)
    {
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