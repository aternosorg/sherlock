<?php

namespace Aternos\Sherlock\Maps;

class URLObfuscationMap extends ObfuscationMap
{
    public function __construct($url)
    {
        parent::__construct(file_get_contents($url));
    }
}