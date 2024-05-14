<?php

namespace PlatformXMLBuilder\Platforms\Helpers;

class RentifyHelper
{
    public static function getTipoImovel (string $propertyTypeEnglish): string
    {
        $typeEnglishToPortuguese = [
            "HOUSE"       => 'CASA',
            "APARTMENT"   => 'APARTAMENTO',
            "STORE"       => 'LOJA',
            "PENTHOUSE"   => 'COBERTURA',
        ];

        return $typeEnglishToPortuguese[$propertyTypeEnglish];
    }

    public static function getDisponibilidade (bool $propertyForSale, bool $propertyForRent): string
    {
        if ($propertyForSale && $propertyForRent) 
        {
            return 'Venda e Locação';
        }

        if ($propertyForSale)
        {
            return 'Venda';
        }

        if ($propertyForRent)
        {
            return 'Locação';
        }

        return '';
    }
}