<?php

namespace Bundles\CustomerBundle\Form;

use Domain\Customer\ValueObject\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EmailType.
 */
class EmailType extends AbstractType implements DataMapperInterface, DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setDataMapper($this)
            ->addViewTransformer($this)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => null,
        ]);
    }

    public function getParent()
    {
        return TextType::class;
    }

    /**
     * @param mixed                        $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms[0]->setData($data ? $data->getEmail() : '');
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param mixed                        $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        try {
            $data = new Email($forms[0]->getData());
        } catch (\Exception $e) {
            $forms[0]->addError(new FormError($e->getMessage()));
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed|string
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (\is_string($value)) {
            return $value;
        }

        if (!$value instanceof Email) {
            throw new TransformationFailedException('Expected a Email object.');
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     *
     * @return Email|mixed
     */
    public function reverseTransform($value)
    {
        if ('' === $value || null === $value) {
            throw new TransformationFailedException('Email can not be empty!');
        }
        if (!\is_string($value)) {
            throw new TransformationFailedException('Email must be a string!');
        }

        return new Email($value);
    }
}
