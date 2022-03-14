<?php

namespace Aternos\Sherlock\MapLocator\LauncherMeta;

class LauncherMetaVersionInfo
{
    protected string $id;
    protected string $type;
    protected string $url;
    protected string $releaseTime;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->type = $data->type;
        $this->url = $data->url;
        $this->releaseTime = $data->releaseTime;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getReleaseTime(): string
    {
        return $this->releaseTime;
    }

    public function getVersion(): LauncherMetaVersion
    {
        return new LauncherMetaVersion(LauncherMetaVersionList::getJSON($this->getUrl()));
    }
}