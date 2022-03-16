<?php

namespace Aternos\Sherlock\MappedData;

class MappedMethod
{

    /**
     * @param MappedClass|null $class
     * @param int|null $startLine
     * @param int|null $endLine
     * @param string $name
     * @param string $unmappedName
     */
    public function __construct(protected ?MappedClass $class, protected ?int $startLine, protected ?int $endLine, protected string $name, protected string $unmappedName)
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
     * @return int
     */
    public function getStartLine(): int
    {
        return $this->startLine;
    }

    /**
     * @return int
     */
    public function getEndLine(): int
    {
        return $this->endLine;
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