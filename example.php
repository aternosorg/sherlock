<?php
require_once('./vendor/autoload.php');

use Aternos\Sherlock\Log\Log;
use Aternos\Sherlock\MapLocator\LauncherMetaMapLocator;
use Aternos\Sherlock\Maps\URLObfuscationMap;


if (count($argv) < 4 || !file_exists($argv[1])) {
    echo "Usage: <file> <version> client|server [output-file]";
    exit(1);
}

echo "Finding mappings...\n";
$map = new URLObfuscationMap((new LauncherMetaMapLocator($argv[2], $argv[3]))->findMappingURL());

$log = new Log(file_get_contents($argv[1]), $map);
echo "Deobfuscating log...\n";
file_put_contents($argv[4] ?? ((str_ends_with($argv[1], ".log") ? substr($argv[1], 0, strlen($argv[1]) - 4) : $argv[1])
        . ".deobfuscated.log"), $log->getDeobfuscatedContent());
echo "Done!";