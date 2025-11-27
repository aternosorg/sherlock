<?php

namespace Aternos\Sherlock\MapLocator;

use SimpleXMLElement;

class FabricMavenMapLocator extends MapLocator
{

    public function __construct(string $version)
    {
        parent::__construct($version, "yarn");
    }

    public function findMappingURL(): ?string
    {
        $versionList = self::getXML("https://maven.fabricmc.net/net/fabricmc/yarn/maven-metadata.xml");
        $latestBuildID = null;
        $latestVersion = null;
        foreach ($versionList->versioning->versions->version as $version) {
            if (preg_match("/^".preg_quote($this->version)."((?:\+build)?)\.(\d+)$/", $version[0], $matches)) {

                $buildID = $matches[2];
                if ($latestVersion === null || $buildID > $latestBuildID) {
                    $latestBuildID = $buildID;
                    $latestVersion = $version;
                }
            }
        }

        if ($latestVersion === null) {
            return null;
        }

        return "https://maven.fabricmc.net/net/fabricmc/yarn/$latestVersion[0]/yarn-$latestVersion[0]-tiny.gz";
    }


    /**
     * @param string $url
     * @return SimpleXMLElement
     * @throws \Exception
     */
    static public function getXML(string $url): SimpleXMLElement
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        return new SimpleXMLElement($result);
    }
}
