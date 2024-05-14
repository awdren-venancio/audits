<?php

use PlatformXMLBuilder\Platforms\Estatify\EstatifyXMLBuilder;
use PlatformXMLBuilder\Platforms\Rentify\RentifyXMLBuilder;
use PlatformXMLBuilder\Platforms\Helpers\XMLHelper;

require 'vendor/autoload.php';

$builders = require 'config/builders.php';

$properties = []; // carregar os dados dos arquivos JSON

const BASE_PATH = __DIR__;
$collection = glob(BASE_PATH.'/database/properties/*.json');
foreach ($collection as $jsonPath) {
    $fileJson = file_get_contents($jsonPath);
    $properties[] = get_object_vars(json_decode($fileJson));
}

foreach ($builders as $portal => $builderClass) {
    $builder = new $builderClass();
    $xml = $builder->buildXML($properties);
    XMLHelper::saveXML($xml, $portal);
}

echo 'solução finalizada!';
