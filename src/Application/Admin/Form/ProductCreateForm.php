<?php

namespace Application\Admin\Form;

use Bundles\CoreBundle\Form\PhpMoneyType;
use Bundles\ProductBundle\Command\ProductCreateCommand;
use Bundles\ProductBundle\Doctrine\Type\TagsType;
use Bundles\ProductBundle\Form\ProductNameType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductCreateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ProductNameType::class, ['label' => 'Intitulé'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('price', PhpMoneyType::class, ['label' => 'Prix'])
            ->add('tags', TagsType::class, ['label' => 'Mots-clefs'])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ProductCreateCommand::class]);
    }
}
