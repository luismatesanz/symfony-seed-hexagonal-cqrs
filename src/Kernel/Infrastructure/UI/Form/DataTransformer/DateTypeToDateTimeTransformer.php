<?php
namespace App\Kernel\Infrastructure\UI\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class DateTypeToDateTimeTransformer implements DataTransformerInterface
{
    public function transform($value) : ?string
    {
        return $value;
    }

    public function reverseTransform($value) : \DateTime
    {
        if (strlen($value) === 10) {
            $value .= " 00:00:00";
        }
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        if (!$date) {
            throw new TransformationFailedException('Invalid date format');
        }
        return $date;
    }
}
