<?php

namespace Bundles\CustomerBundle\Form;

use Bundles\CustomerBundle\Command\CustomerRegistrationCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CustomerRegistrationForm.
 */
class CustomerRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'form.email', 'translation_domain' => 'form'])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options' => ['label' => 'form.password', 'translation_domain' => 'form'],
                'second_options' => ['label' => 'form.repeat_password', 'translation_domain' => 'form'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'form.create_account', 'translation_domain' => 'form'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => CustomerRegistrationCommand::class]);
    }
}
