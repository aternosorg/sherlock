<?php

namespace Aternos\Sherlock\LauncherMeta;

class LauncherMetaVersion
{
    protected LauncherMetaDownloadOptions $downloadOptions;
    protected string $id;
    protected string $type;
    protected string $releaseTime;

    public function __construct($data)
    {
        $this->downloadOptions = new LauncherMetaDownloadOptions($data->downloads);
        $this->id = $data->id;
        $this->type = $data->type;
        $this->releaseTime = $data->releaseTime;
    }

    /**
     * @return LauncherMetaDownloadOptions
     */
    public function getDownloadOptions(): LauncherMetaDownloadOptions
    {
        return $this->downloadOptions;
    }
}