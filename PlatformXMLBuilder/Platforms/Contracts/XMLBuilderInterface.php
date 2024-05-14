<?php

namespace PlatformXMLBuilder\Platforms\Contracts;

interface XMLBuilderInterface
{
    public function buildXML(array $properties): string;
}
