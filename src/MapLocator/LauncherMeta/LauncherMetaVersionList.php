<?php

namespace Aternos\Sherlock\MapLocator\LauncherMeta;

class LauncherMetaVersionList
{
    /**
     * @var LauncherMetaVersionInfo[]
     */
    private array $versions;

    public function __construct($data)
    {
        $this->versions = [];
        foreach ($data->versions as $version) {
            $this->versions[] = new LauncherMetaVersionInfo($version);
        }
    }

    /**
     * @return LauncherMetaVersionInfo[]
     */
    public function getVersions(): array
    {
        return $this->versions;
    }

    /**
     * get a specific version
     * @param $id string e.g. 1.18.2
     * @return LauncherMetaVersionInfo|null
     */
    public function getVersion(string $id): ?LauncherMetaVersionInfo
    {
        foreach ($this->versions as $version) {
            if ($version->getId() === $id) {
                return $version;
            }
        }
        return null;
    }

    static public function getJSON(string $url): mixed
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result);
    }

    /**
     * get version list
     * @return LauncherMetaVersionList
     */
    static public function getVersionList():LauncherMetaVersionList
    {
        return new LauncherMetaVersionList(self::getJSON("https://launchermeta.mojang.com/mc/game/version_manifest.json"));
    }
}