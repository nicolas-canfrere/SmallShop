<?php

namespace Bundles\CustomerBundle\Form;

use Domain\Customer\Enum\Civility as CivilityEnum;
use Domain\Customer\ValueObject\Civility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CivilityType.
 */
class CivilityType extends AbstractType implements DataMapperInterface
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'civility',
                ChoiceType::class,
                [
                    'expanded' => false,
                    'multiple' => false,
                    'choices' => CivilityEnum::toArray(),
                ]
            )
            ->setDataMapper($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'choices' => CivilityEnum::toArray(),
                'data_class' => Civility::class,
                'empty_data' => null,
            ]
        );
    }

    /**
     * @param mixed                                                $data
     * @param \Symfony\Component\Form\FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['civility']->setData($data ? $data->getCivility() : '');
    }

    /**
     * @param \Symfony\Component\Form\FormInterface[]|\Traversable $forms
     * @param mixed                                                $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        try {
            $data = new Civility($forms['civility']->getData());
        } catch (\Exception $e) {
            $forms['civility']->addError(new FormError($e->getMessage()));
        }
    }
}
