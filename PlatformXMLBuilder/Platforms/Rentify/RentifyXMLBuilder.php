<?php

namespace PlatformXMLBuilder\Platforms\Rentify;

use PlatformXMLBuilder\Platforms\Contracts\XMLBuilderInterface;
use PlatformXMLBuilder\Platforms\Helpers\XMLHelper;
use Spatie\ArrayToXml\ArrayToXml;

class RentifyXMLBuilder implements XMLBuilderInterface
{
    public function propertyTypeConvert (string $propertyTypeEnglish): string
    {
        $typeEnglishToPortuguese = [
            "HOUSE"       => 'CASA',
            "APARTMENT"   => 'APARTAMENTO',
            "STORE"       => 'LOJA',
            "PENTHOUSE"   => 'COBERTURA',
        ];

        return $typeEnglishToPortuguese[$propertyTypeEnglish];
    }

    public function propertyForSaleRentConvert (bool $propertyForSale, bool $propertyForRent): string
    {
        if ($propertyForSale && $propertyForRent) 
        {
            return 'Venda e Locação';
        }

        if ($propertyForSale && !$propertyForRent)
        {
            return 'Venda';
        }

        if (!$propertyForSale && $propertyForRent)
        {
            return 'Locação';
        }

        return '';
    }

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
                'tipoImovel'          => $this->propertyTypeConvert($property['propertyType']),
                'disponibilidade'     => $this->propertyForSaleRentConvert($property['propertyForSale'], $property['propertyForRent']),
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
