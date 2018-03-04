<?php

namespace App\Kernel\Infrastructure\UI\Serializer;

use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;

class LowerCamelCaseNamingStrategy extends CamelCaseNamingStrategy
{
    public function translateName(PropertyMetadata $property)
    {
        $property = parent::translateName($property);
        return lcfirst($property);
    }
}
