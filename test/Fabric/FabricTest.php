<?php

namespace Aternos\Sherlock\Test\Fabric;

use Aternos\Sherlock\MapLocator\FabricMavenMapLocator;
use Aternos\Sherlock\Maps\GZURLYarnMap;
use Aternos\Sherlock\ObfuscatedString;
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
        $log = new ObfuscatedString(file_get_contents("./test/Fabric/fabric.log"), $map);
        self::assertEquals(file_get_contents("./test/Fabric/fabric.mapped.log"), $log->getMappedContent());
    }
}