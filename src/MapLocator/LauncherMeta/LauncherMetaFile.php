<?php

namespace Aternos\Sherlock\MapLocator\LauncherMeta;

class LauncherMetaFile
{
    protected string $sha1;
    protected int $size;
    protected string $url;

    public function __construct($data)
    {
        $this->sha1 = $data->sha1;
        $this->size = $data->size;
        $this->url = $data->url;
    }

    /**
     * @return string
     */
    public function getSha1(): string
    {
        return $this->sha1;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}