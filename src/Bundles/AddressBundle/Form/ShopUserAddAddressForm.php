<?php

namespace Bundles\AddressBundle\Form;

use Bundles\AddressBundle\Command\AddressCreateCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShopUserAddAddressForm.
 */
class ShopUserAddAddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, ['label' => 'form.fullname', 'translation_domain' => 'form'])
            ->add('street', TextType::class, ['label' => 'form.street', 'translation_domain' => 'form'])
            ->add('postalCode', TextType::class, ['label' => 'form.postalcode', 'translation_domain' => 'form'])
            ->add('city', TextType::class, ['label' => 'form.city', 'translation_domain' => 'form'])
            ->add('country', TextType::class, ['label' => 'form.country', 'translation_domain' => 'form'])
            ->add('submit', SubmitType::class, ['label' => 'form.save', 'translation_domain' => 'form']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => AddressCreateCommand::class]);
    }
}
