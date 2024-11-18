<?php
require_once('./vendor/autoload.php');

use Aternos\Sherlock\MapLocator\FabricMavenMapLocator;
use Aternos\Sherlock\MapLocator\LauncherMetaMapLocator;
use Aternos\Sherlock\Maps\GZURLYarnMap;
use Aternos\Sherlock\Maps\URLVanillaObfuscationMap;
use Aternos\Sherlock\ObfuscatedString;

$inputPath = $argv[1] ?? null;

if (count($argv) < 4 || !file_exists($inputPath)) {
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
        $url = (new LauncherMetaMapLocator($ver, $type))->findMappingURL();
        echo "Found mappings: $url\n";
        $map = new URLVanillaObfuscationMap($url);
    }
}
catch (\Exception $e) {
    echo $e;
    exit;
}

$log = new ObfuscatedString(file_get_contents($inputPath), $map);

echo "Remapping log...\n";

$content = $log->getMappedContent();
$fileName = pathinfo($inputPath, PATHINFO_FILENAME);
$fileExtension = pathinfo($inputPath, PATHINFO_EXTENSION);
$directory = pathinfo($inputPath, PATHINFO_DIRNAME);
$targetPath = $directory . DIRECTORY_SEPARATOR . $fileName . ".mapped." . $fileExtension;
file_put_contents($targetPath, $content);
echo "Done!";
