<?php

namespace Aternos\Sherlock\MappedData;

class MappedMethod
{
    private MappedClass $class;
    private int $startLine;
    private int $endLine;
    private string $returnType;
    private string $name;
    private array $argumentTypes;
    private string $obfuscatedName;

    /**
     * @param MappedClass $class
     * @param int $startLine
     * @param int $endLine
     * @param string $returnType
     * @param string $name
     * @param string $argumentTypes
     * @param string $obfuscatedName
     */
    public function __construct(MappedClass $class, int $startLine, int $endLine, string $returnType, string $name, string $argumentTypes, string $obfuscatedName)
    {
        $this->class = $class;
        $this->startLine = $startLine;
        $this->endLine = $endLine;
        $this->returnType = $returnType;
        $this->name = $name;
        $this->argumentTypes = preg_split("/,\s?/", $argumentTypes);
        $this->obfuscatedName = $obfuscatedName;
    }

    /**
     * @return MappedClass
     */
    public function getClass(): MappedClass
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
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getArgumentTypes(): array
    {
        return $this->argumentTypes;
    }

    /**
     * @return string
     */
    public function getObfuscatedName(): string
    {
        return $this->obfuscatedName;
    }
}