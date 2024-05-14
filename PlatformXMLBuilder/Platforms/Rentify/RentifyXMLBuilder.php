<?php

namespace PlatformXMLBuilder\Platforms\Rentify;

use PlatformXMLBuilder\Platforms\Contracts\XMLBuilderInterface;
use PlatformXMLBuilder\Platforms\Helpers\RentifyHelper;
use Spatie\ArrayToXml\ArrayToXml;

class RentifyXMLBuilder implements XMLBuilderInterface
{
    public function buildXML(array $properties): string
    {
        $imoveis = [];

        foreach ($properties as $property) {

            if (!in_array('rentify', $property['publishFor'])) {
                continue;
            }

            $imovel = [
                'imovel' => [
                    '_attributes' => [
                        'dataCriacao' => $property['created'],
                    ],
                ],
                'anoConstrucao'       => $property['buildYear'],
                'contatoTelefone'     => $property['realStatePhone'],
                'referencia'          => $property['propertyRefence'],
                'tipoImovel'          => RentifyHelper::getTipoImovel($property['propertyType']),
                'disponibilidade'     => RentifyHelper::getDisponibilidade($property['propertyForSale'], $property['propertyForRent']),
                'valorVenda'          => $property['propertySalesPrice'],
                'valorLocacao'        => $property['propertyRentPrice'],
                'enderecoRua'         => $property['addressStreet'],
                'enderecoNumero'      => $property['addressNumber'],
                'enderecoComplemento' => $property['addressComplement'],
                'enderecoBairro'      => $property['addressDistrict'],
                'enderecoCidade'      => $property['addressCity'],
                'enderecoEstado'      => $property['addressState'],
                'enderecoPais'        => $property['addressCountry'],
                'enderecoCEP'         => $property['addressZipCode'],
            ];

            $imoveis[] = $imovel;
        }

        $xml = ArrayToXml::convert(['imovel' => $imoveis], 'imoveis', true, 'UTF-8');

        return $xml;
    }
    
}
