<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 19:29
 */

namespace Application\Admin\Form;


use Bundles\CoreBundle\Form\PhpMoneyType;
use Bundles\ProductBundle\Form\ProductNameType;
use Domain\Product\Command\ProductUpdateCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductUpdateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ProductNameType::class, ['label' => 'Name'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('price', PhpMoneyType::class, ['label' => 'Price'])
            ->add('onSale', CheckboxType::class, ['label' => 'On sale'])
            ->add('submit', SubmitType::class, ['label' => 'Save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ProductUpdateCommand::class]);
    }

}
