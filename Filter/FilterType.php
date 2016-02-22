<?php

namespace Victoire\Widget\FilterBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Filter type.
 */
class FilterType extends AbstractType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listing', HiddenType::class, [
                'data' => $options['listing_id'],
            ]);

        if ($options['filter']) {
            $builder->add($options['filter'], $options['filter'], $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->configureOptions([
            'csrf_protection' => false,
            'listing_id'      => null,
            'widget'          => null,
            'multiple'        => false,
            'filter'          => null,
        ]);
    }
}
