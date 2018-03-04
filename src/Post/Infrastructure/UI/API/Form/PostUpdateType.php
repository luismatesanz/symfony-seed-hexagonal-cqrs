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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;

final class PostUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(
                'date',
                DateType::class,
                    array(
                        'constraints' => array(
                            new Assert\DateTime()
                        )
                    )
                )
            ->add(
                'title',
                TextType::class,
                array(
                    'constraints' => array(
                        new Length(
                            array(
                                'min' => 10,
                                'minMessage' => 'Your field TITLE must be at least {{ limit }} characters long'
                            )
                        )
                    )
                )
            )
            ->add('text', TextType::class)
            ->add(
                'comments',
                CollectionType::class,
                array(
                    'entry_type' => PostCommentType::class,
                    'allow_add' => true
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UpdatePostCommand::class,
            'empty_data' => function (FormInterface $form) {
                return new UpdatePostCommand(
                    $form->getConfig()->getOption('id'),
                    $form->get('date')->getData(),
                    $form->get('title')->getData(),
                    $form->get('text')->getData(),
                    $form->get('comments')->getData()
                );
            },
            'id' => null,
            'mapped' => false,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix() : string
    {
        return '';
    }
}
