<?php
require_once('./vendor/autoload.php');

use Aternos\Sherlock\MapLocator\FabricMavenMapLocator;
use Aternos\Sherlock\MapLocator\LauncherMetaMapLocator;
use Aternos\Sherlock\Maps\GZURLYarnMap;
use Aternos\Sherlock\Maps\URLVanillaObfuscationMap;
use Aternos\Sherlock\ObfuscatedString;

if (count($argv) < 4 || !file_exists($argv[1])) {
    echo "Usage: <file> <version> client|server|yarn [output-file]";
    exit(1);
}


$type = $argv[3];
$ver = $argv[2];
echo "Finding mappings...\n";

try {
    if ($type === 'yarn') {
        $url = (new FabricMavenMapLocator($ver))->findMappingURL();
        $map = new GZURLYarnMap($url);
    }
    else {
        $url = (new LauncherMetaMapLocator($argv[2], $argv[3]))->findMappingURL();
        echo "Found mappings: $url\n";
        $map = new URLVanillaObfuscationMap($url);
    }
}
catch (\Exception $e) {
    echo $e;
    exit;
}

$log = new ObfuscatedString(file_get_contents($argv[1]), $map);
echo "Remapping log...\n";
file_put_contents($argv[4] ?? ((str_ends_with($argv[1], ".log") ? substr($argv[1], 0, strlen($argv[1]) - 4) : $argv[1])
        . ".mapped.log"), $log->getMappedContent());
echo "Done!";