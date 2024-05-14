<?php

namespace PlatformXMLBuilder\Platforms\Estatify;

use PlatformXMLBuilder\Platforms\Contracts\XMLBuilderInterface;
use Spatie\ArrayToXml\ArrayToXml;

class EstatifyXMLBuilder implements XMLBuilderInterface
{
    public function buildXML(array $properties): string
    {
        $collection = [];
        
        foreach ($properties as $property) {
            
            if (!in_array('estatify', $property['publishFor'])) {
                continue;
            }

            $propertyXml = [
                'created'   => $property['created'],
                'realState' => [
                    'phone' => $property['realStatePhone'],
                    'email' => $property['realStateEmail'],
                ],
                'property' => [
                    'year'    => $property['buildYear'],
                    'ref'     => $property['propertyRefence'],
                    'type'    => $property['propertyType'],
                    'forSale' => $property['propertyForSale'] ? 'sim' : 'não',
                    'forRent' => $property['propertyForRent'] ? 'sim' : 'não',
                    'price'   => [
                        'sales' => $property['propertySalesPrice'],
                        'rent'  => $property['propertyRentPrice'],
                    ],
                ],
                'address' => [
                    'street'      => $property['addressStreet'],
                    'number'      => $property['addressNumber'],
                    'complement'  => $property['addressComplement'],
                    'district'    => $property['addressDistrict'],
                    'city'        => $property['addressCity'],
                    'state'       => $property['addressState'],
                    'country'     => $property['addressCountry'],
                    'zipCode'     => $property['addressZipCode'],
                ],
            ];

            $collection[] = $propertyXml;
        }

        $xml = ArrayToXml::convert(['property' => $collection], 'collection', true, 'UTF-8');

        return $xml;
    }
}
