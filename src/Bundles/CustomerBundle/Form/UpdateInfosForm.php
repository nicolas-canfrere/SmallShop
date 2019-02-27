<?php

namespace Bundles\CustomerBundle\Form;

use Bundles\CustomerBundle\Command\CustomerUpdateInfosCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UpdateInfosForm.
 */
class UpdateInfosForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label' => 'form.email', 'translation_domain' => 'form'])
            ->add('civility', CivilityType::class, ['label' => 'form.civility', 'translation_domain' => 'form'])
            ->add('firstname', TextType::class, ['label' => 'form.firstname', 'translation_domain' => 'form'])
            ->add('lastname', TextType::class, ['label' => 'form.lastname', 'translation_domain' => 'form'])
            ->add('submit', SubmitType::class, ['label' => 'form.save', 'translation_domain' => 'form'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => CustomerUpdateInfosCommand::class]);
    }
}
