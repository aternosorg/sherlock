<?php

namespace Aternos\Sherlock\Maps;

class URLVanillaObfuscationMap extends VanillaObfuscationMap
{
    public function __construct($url)
    {
        parent::__construct(file_get_contents($url));
    }
}