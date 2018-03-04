<?php

declare(strict_types = 1);

namespace App\User\Infrastructure\UI\API\Form;

use App\User\Application\Command\AddUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

final class UserAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                array('required' => true,
                    'constraints' => array(
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
                array(
                    'constraints' => array(
                        new Constraints\Email()
                    )
                )
            )
            ->add(
                'password',
                TextType::class,
                array(
                    'constraints' => array(
                        new Constraints\Length(
                            array(
                                'min' => 4,
                                'minMessage' => 'Your field PASSWORD must be at least {{ limit }} characters long'
                            )
                        )
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AddUserCommand::class,
            'empty_data' => function (FormInterface $form) {
                return new AddUserCommand(
                    $form->get('username')->getData(),
                    $form->get('email')->getData(),
                    $form->get('password')->getData()
                );
            },
            'mapped' => false,
            'csrf_protection' => false
        ));
    }

    public function getBlockPrefix() : string
    {
        return '';
    }
}
