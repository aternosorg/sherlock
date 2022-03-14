<?php

namespace Vanilla;

use Aternos\Sherlock\Log\Log;
use Aternos\Sherlock\MapLocator\FabricMavenMapLocator;
use Aternos\Sherlock\MapLocator\LauncherMetaMapLocator;
use Aternos\Sherlock\Maps\GZURLYarnMap;
use Aternos\Sherlock\Maps\URLVanillaObfuscationMap;
use PHPUnit\Framework\TestCase;

class FabricTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testRemapLog(): void
    {
        $url = (new FabricMavenMapLocator("1.18.2-pre1"))->findMappingURL();
        $map = new GZURLYarnMap($url);
        $log = new Log(file_get_contents("./test/tests/Fabric/fabric.log"), $map);
        self::assertEquals(file_get_contents("./test/tests/Fabric/fabric.mapped.log"), $log->getMappedContent());
    }
}