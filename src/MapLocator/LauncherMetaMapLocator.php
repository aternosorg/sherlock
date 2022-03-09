<?php

namespace Aternos\Sherlock\MapLocator;

use Aternos\Sherlock\LauncherMeta\LauncherMetaFile;
use Aternos\Sherlock\LauncherMeta\LauncherMetaVersionList;

class LauncherMetaMapLocator extends MapLocator
{
    /**
     * find the mappings file using launcher meta
     * @return LauncherMetaFile|null
     */
    public function findMappingFile(): ?LauncherMetaFile
    {
        $versionInfo = LauncherMetaVersionList::getVersionList()->getVersion($this->version);
        if ($versionInfo === null) {
            throw new \InvalidArgumentException("Unknown version $this->version");
        }

        return $versionInfo->getVersion()->getDownloadOptions()->getMappings($this->mappingType) ?? null;
    }

    public function findMappingURL(): ?string
    {
        $file = $this->findMappingFile();
        return $file?->getUrl();
    }
}