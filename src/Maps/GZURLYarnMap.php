<?php

namespace Aternos\Sherlock\Maps;

class GZURLYarnMap extends YarnMap
{
    public function __construct(string $url)
    {
        parent::__construct(gzdecode(file_get_contents($url)));
    }
}