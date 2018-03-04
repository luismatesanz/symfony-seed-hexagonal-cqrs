<?php

declare(strict_types = 1);

namespace App\User\Infrastructure\UI\API\Form;

use App\Kernel\Infrastructure\UI\Form\Type\BooleanType;
use App\User\Application\Command\UpdateUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

final class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                array('constraints' => array(
                        new Constraints\Length(
                            array(
                                'min' => 4,
                                'minMessage' => 'Your field USERNAME must be at least {{ limit }} characters long'
                            )
                        )
                    )
                )
            )
            ->add(
                'email',
                TextType::class,
                array('constraints' => array(
                        new Constraints\Email()
                    )
                )
            )
            ->add(
                'enabled',
                BooleanType::class,
                array(
                    'constraints' => array(
                        new Constraints\NotBlank()
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UpdateUserCommand::class,
            'empty_data' => function (FormInterface $form) {
                return new UpdateUserCommand(
                    $form->getConfig()->getOption('id'),
                    $form->get('username')->getData(),
                    $form->get('email')->getData(),
                    $form->get('enabled')->getData()
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
