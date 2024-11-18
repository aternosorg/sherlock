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
    public function testRemap1_18_2_pre1_log(): void
    {
        $url = (new FabricMavenMapLocator("1.18.2-pre1"))->findMappingURL();
        $map = new GZURLYarnMap($url);
        $log = new ObfuscatedString(file_get_contents("./test/Fabric/1.18.2-pre1.log"), $map);
        self::assertEquals(file_get_contents("./test/Fabric/1.18.2-pre1.mapped.log"), $log->getMappedContent());
    }

    /**
     * @throws \Exception
     */
    public function testRemap_1_21_3_crash_report(): void
    {
        $url = (new FabricMavenMapLocator("1.21.3"))->findMappingURL();
        $map = new GZURLYarnMap($url);
        $log = new ObfuscatedString(file_get_contents("./test/Fabric/1.21.3-crash-report.txt"), $map);
        self::assertEquals(file_get_contents("./test/Fabric/1.21.3-crash-report.mapped.txt"), $log->getMappedContent());
    }
}
