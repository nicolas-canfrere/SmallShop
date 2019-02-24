<?php

namespace Bundles\ProductBundle\Form;

use Domain\Product\ValueObject\ProductName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductNameType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name'])
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ProductName::class,
                'empty_data' => null,
            ]
        );
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['name']->setData($data ? $data->getName() : '');
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        try {
            $data = new ProductName($forms['name']->getData());
        } catch (\Exception $e) {
            $forms['name']->addError(new FormError($e->getMessage()));
        }
    }
}
