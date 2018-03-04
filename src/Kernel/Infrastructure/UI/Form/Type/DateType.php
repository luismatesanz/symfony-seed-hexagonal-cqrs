<?php
namespace App\Kernel\Infrastructure\UI\Form\Type;

use App\Kernel\Infrastructure\UI\Form\DataTransformer\DateTypeToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DateTypeToDateTimeTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
        ));
    }

    public function getName()
    {
        return 'date';
    }
}
