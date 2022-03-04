<?php
require_once('./vendor/autoload.php');

use Aternos\Sherlock\Log\Log;
use Aternos\Sherlock\Maps\URLObfuscationMap;

const mappings_url = "https://launcher.mojang.com/v1/objects/ee44979b031f2e937dd4737ebcfbddd553aee52d/server.txt";
define("log_content", file_get_contents('./obfuscated-example.log'));

echo "Parsing obfuscation Map...\n";
$map = new URLObfuscationMap(mappings_url);
$log = new Log(log_content, $map);
echo "Deobfuscating log...\n";
file_put_contents("./deobfuscated-example.log", $log->getDeobfuscatedContent());