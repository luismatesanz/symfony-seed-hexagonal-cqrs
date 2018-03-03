<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Form;

use App\Kernel\Infrastructure\UI\Form\Type\DateType;
use App\Post\Application\Command\UpdatePostCommand;
use App\Post\Infrastructure\UI\API\Form\Aggregate\PostCommentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PostUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('date', DateType::class)
            ->add('title', TextType::class)
            ->add('text', TextType::class)
            ->add(
                'comments',
                CollectionType::class,
                array(
                'entry_type' => PostCommentType::class
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Post\Application\Command\UpdatePostCommand',
            'empty_data' => function (FormInterface $form) {
                $a = $form->get('comments')->getData();
                new UpdatePostCommand(
                    '1',
                    $form->get('date')->getData(),
                    $form->get('title')->getData(),
                    $form->get('text')->getData(),
                    $form->get('comments')->getData()
                );
            },
            'id' => null,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix() : string
    {
        return '';
    }
}
