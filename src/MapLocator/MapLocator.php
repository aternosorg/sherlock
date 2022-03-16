<?php

namespace Aternos\Sherlock\MapLocator;

abstract class MapLocator
{
    /**
     * @param string $version e.g. 1.16.5
     * @param string $mappingType e.g. server client
     */
    public function __construct(protected string $version, protected string $mappingType)
    {
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