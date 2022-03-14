<?php

namespace Aternos\Sherlock\MappedData;

class MappedMethod
{
    private ?MappedClass $class;
    private ?int $startLine;
    private ?int $endLine;
    private string $name;
    private string $unmappedName;

    /**
     * @param MappedClass|null $class
     * @param int|null $startLine
     * @param int|null $endLine
     * @param string $name
     * @param string $unmappedName
     */
    public function __construct(?MappedClass $class, ?int $startLine, ?int $endLine, string $name, string $unmappedName)
    {
        $this->class = $class;
        $this->startLine = $startLine;
        $this->endLine = $endLine;
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