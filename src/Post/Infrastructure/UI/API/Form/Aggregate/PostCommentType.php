<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Form\Aggregate;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PostCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('id', TextType::class)
            ->add('userId', TextType::class)
            ->add('text', TextType::class)
        ;

    }

    public function getName()
    {
        return '';
    }
}