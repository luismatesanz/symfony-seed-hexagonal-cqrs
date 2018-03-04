<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Form\Aggregate;

use App\Post\Application\Command\Aggregate\PostCommentCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PostCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('id', TextType::class, array('mapped' => false, 'required' => false))
            ->add('userId', TextType::class, array('mapped' => false))
            ->add('text', TextType::class, array('mapped' => false, 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PostCommentCommand::class,
            'empty_data' => function (FormInterface $form) {
                return new PostCommentCommand(
                    $form->get('id')->getData(),
                    $form->get('userId')->getData(),
                    $form->get('text')->getData()
                );
            },
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
