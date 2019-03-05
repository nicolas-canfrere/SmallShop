<?php

namespace Bundles\ProductBundle\Form;

use Domain\Product\Signature\TagInterface;
use Domain\Product\Signature\TagRepositoryInterface;
use Domain\Product\Tag;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TagsType.
 */
class TagsType extends AbstractType implements ChoiceLoaderInterface, DataTransformerInterface
{
    /**
     * @var TagRepositoryInterface
     */
    protected $tagRepository;
    /**
     * @var ChoiceListInterface
     */
    protected $choiceList;

    /**
     * TagsType constructor.
     *
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CollectionToArrayTransformer());
        $builder->addViewTransformer($this);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['full_name'] = substr($view->vars['full_name'], 0, -2);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['choice_loader' => $this, 'multiple' => true]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @param null $value
     *
     * @return ArrayChoiceList|ChoiceListInterface
     */
    public function loadChoiceList($value = null)
    {
        if (!null === $this->choiceList) {
            return $this->choiceList;
        }

        $tags = $this->tagRepository->all();

        $closure = function (TagInterface $tag) {
            return null === $tag ? '' : (string) $tag;
        };

        return new ArrayChoiceList($tags, $closure);
    }

    /**
     * @param array $values
     * @param null  $value
     *
     * @return array
     *
     * @throws \Exception
     */
    public function loadChoicesForValues(array $values, $value = null)
    {
        if (empty($values)) {
            return [];
        }
        if (null !== $this->choiceList) {
            return $this->choiceList->getChoicesForValues($values);
        }
        //return $this->tagRepository->getTags($values);

        $tags = [];

        foreach ($values as $name) {
            if (empty($name)) {
                continue;
            }
            $tag = $this->tagRepository->oneByName($name);

            if (null === $tag) {
                $tag = new Tag(Uuid::uuid4()->toString(), $name);
            }

            $tags[] = $tag;
        }

        return $tags;
    }

    /**
     * @param array $choices
     * @param null  $value
     *
     * @return array|string[]
     */
    public function loadValuesForChoices(array $choices, $value = null)
    {
        if (empty($choices)) {
            return [];
        }
        if (null !== $this->choiceList) {
            return $this->choiceList->getValuesForChoices($choices);
        }


        return array_map(function (TagInterface $tag) {
            return (string) $tag;
        }, $choices);
    }

    /**
     * @param mixed $value
     *
     * @return mixed|string
     */
    public function transform($value)
    {
        if (empty($value)) {
            return '';
        }

        return implode(', ', $value);
    }

    /**
     * @param mixed $value
     *
     * @return array|mixed
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return [];
        }
        $value = explode(',', $value);

        return array_map(function ($str) {
            return trim($str);
        }, $value);
    }
}
