# Sherlock
### About
Sherlock is a PHP library that investigates obscure Minecraft logs
and makes them more readable by replacing obfuscated stacktraces
with useful names using Mappings provided by Mojang (or FabricMC).

### Installation
```
composter require aternos/sherlock
```

## Usage

### Getting an Obfuscation Map
To process a log you need the correct Obfuscation Map.
You can get the url of a Vanilla Obfuscation Map for any Minecraft version 
(including snapshots) using the LauncherMetaMapLocator:
```php
$url = new \Aternos\Sherlock\MapLocator\LauncherMetaMapLocator("1.18.2-pre1", "server");
$map = new \Aternos\Sherlock\Maps\URLVanillaObfuscationMap($url)
```
The second parameter in this example is the mapping type. Mojang releases both server 
and client Obfuscation Maps, so you will have to pick the one that matches your environment.

#### Fabric
Fabric logs are already mapped from Vanilla's obfuscated names to Intermediary. 
These are different mappings that aim to keep names consistent across multiple versions.
To process such a log you need the corresponding Yarn mappings. You can get the URL to a gzip 
map file from the Fabric Maven repository like this:
```php
$url = new \Aternos\Sherlock\MapLocator\FabricMavenMapLocator("1.18.2-pre1");
$map = new \Aternos\Sherlock\Maps\GZURLYarnMap($url);
```
Yarn mappings are not environment dependent since Intermediary already takes care of the differences.


### Remapping a log using the Obfuscation Map
```php
$log = new \Aternos\Sherlock\ObfuscatedString(file_get_contents("test.log"), $map);
$remappedContent = $log->getMappedContent();
file_put_contents("test.mapped.log", $remappedContent)
```
The content will only be mapped once you try to retrieve it and will be stored from then on.
