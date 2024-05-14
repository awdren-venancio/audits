<?php

namespace PlatformXMLBuilder\Platforms\Helpers;

use Spatie\ArrayToXml\ArrayToXml;

class XMLHelper
{
    public static function saveXML(string $xml, string $portal): void
    {
        file_put_contents("./cache/{$portal}.xml", $xml);
    }
}
