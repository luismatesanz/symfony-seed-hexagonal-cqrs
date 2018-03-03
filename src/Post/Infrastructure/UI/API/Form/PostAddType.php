<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Form;

use App\Kernel\Infrastructure\UI\Form\Type\DateType;
use App\Post\Application\Command\AddPostCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PostAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('date', DateType::class)
            ->add('title', TextType::class)
            ->add('text', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Post\Application\Command\AddPostCommand',
            'empty_data' => function (FormInterface $form) {
                return new AddPostCommand(
                    $form->get('date')->getData(),
                    $form->get('title')->getData(),
                    $form->get('text')->getData()
                );
            },
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix() : string
    {
        return '';
    }
}
