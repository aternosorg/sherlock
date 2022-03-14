<?php

namespace Aternos\Sherlock\MappedData;

class MappedField
{
    private MappedClass $class;
    private string $name;
    private string $type;
    private string $unmappedName;

    /**
     * @param MappedClass $class
     * @param string $name
     * @param string $type
     * @param string $unmappedName
     */
    public function __construct(MappedClass $class, string $name, string $type, string $unmappedName)
    {
        $this->class = $class;
        $this->name = $name;
        $this->type = $type;
        $this->unmappedName = $unmappedName;
    }

    /**
     * @return MappedClass
     */
    public function getClass(): MappedClass
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUnmappedName(): string
    {
        return $this->unmappedName;
    }
}