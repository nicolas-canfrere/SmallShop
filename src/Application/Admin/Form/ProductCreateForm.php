<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 18:37
 */

namespace Application\Admin\Form;


use Bundles\CoreBundle\Form\PhpMoneyType;
use Bundles\ProductBundle\Command\ProductCreateCommand;
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
            ->add('name', ProductNameType::class, ['label' => 'Name'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('price', PhpMoneyType::class, ['label' => 'Price'])
            ->add('submit', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ProductCreateCommand::class]);
    }

}
