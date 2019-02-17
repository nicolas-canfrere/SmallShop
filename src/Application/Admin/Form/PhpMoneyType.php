<?php

namespace Application\Admin\Form;


use Money\Currency;
use Money\Money;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MoneyType
 * @package Application\Form
 */
class PhpMoneyType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', MoneyType::class, ['divisor' => 100, 'currency' => ''])
            ->add(
                'currency',
                ChoiceType::class,
                [
                    'choices' => array_flip(Intl::getCurrencyBundle()->getCurrencyNames()),
                ]
            )
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Money::class,
                'empty_data' => null,
            ]
        );
    }

    /**
     * Maps properties of some data to a list of forms.
     *
     * @param mixed $data Structured data
     * @param FormInterface[]|\Traversable $forms A list of {@link FormInterface} instances
     *
     * @throws Exception\UnexpectedTypeException if the type of the data parameter is not supported
     */
    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['amount']->setData($data ? $data->getAmount() : 0);
        $forms['currency']->setData($data ? $data->getCurrency()->getCode() : 'EUR');
    }

    /**
     * Maps the data of a list of forms into the properties of some data.
     *
     * @param FormInterface[]|\Traversable $forms A list of {@link FormInterface} instances
     * @param mixed $data Structured data
     *
     * @throws Exception\UnexpectedTypeException if the type of the data parameter is not supported
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data  = new Money(
            $forms['amount']->getData(),
            new Currency($forms['currency']->getData())
        );
    }
}
