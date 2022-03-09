<?php

namespace Aternos\Sherlock\MapLocator;

abstract class MapLocator
{
    protected string $version;
    protected string $mappingType;

    /**
     * @param string $version e.g. 1.16.5
     * @param string $mappingType e.g. server client
     */
    public function __construct(string $version, string $mappingType)
    {
        $this->version = $version;
        $this->mappingType = $mappingType;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getMappingType(): string
    {
        return $this->mappingType;
    }

    /**
     * get the mapping url
     * @return string|null
     */
    public abstract function findMappingURL(): ?string;
}