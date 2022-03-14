<?php

namespace Vanilla;

use Aternos\Sherlock\Log\Log;
use Aternos\Sherlock\MapLocator\LauncherMetaMapLocator;
use Aternos\Sherlock\Maps\URLVanillaObfuscationMap;
use PHPUnit\Framework\TestCase;

class VanillaTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testRemapLog(): void
    {
        $url = (new LauncherMetaMapLocator("1.18.2-pre1", "server"))->findMappingURL();
        $map = new URLVanillaObfuscationMap($url);
        $log = new Log(file_get_contents("./test/tests/Vanilla/vanilla.log"), $map);
        self::assertEquals(file_get_contents("./test/tests/Vanilla/vanilla.mapped.log"), $log->getMappedContent());
    }
}