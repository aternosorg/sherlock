<?php

use Aternos\Sherlock\Log\Log;
use Aternos\Sherlock\MapLocator\FabricMavenMapLocator;
use Aternos\Sherlock\Maps\GZURLYarnMap;

require_once('./vendor/autoload.php');

$mapLocator = new FabricMavenMapLocator("1.18.2-pre1");
$map = new GZURLYarnMap($mapLocator->findMappingURL());

$log = new Log(file_get_contents("fabric-example.log"), $map);
echo $log->getDeobfuscatedContent();