<?php
namespace App\Kernel\Infrastructure\UI\Form\DataTransformer;

use App\Kernel\Infrastructure\UI\Form\Type\BooleanType;
use Symfony\Component\Form\DataTransformerInterface;

final class BooleanTypeToBooleanTransformer implements DataTransformerInterface
{
    public function transform($value) : bool
    {
        if (true === $value || BooleanType::VALUE_TRUE === (int) $value || (string) $value === BooleanType::VALUE_STRING_TRUE) {
            return BooleanType::VALUE_TRUE;
        }
        return BooleanType::VALUE_FALSE;
    }

    public function reverseTransform($value) : bool
    {
        if (BooleanType::VALUE_TRUE === (int) $value || (string) $value === BooleanType::VALUE_STRING_TRUE) {
            return true;
        }
        return false;
    }
}
