<?php

namespace Victoire\Widget\FilterBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Filter type
 */
class FilterType extends AbstractType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listing', 'hidden', array(
                'data' => $options['listing_id']
            ));

        foreach ($options['filters'] as $filter) {
            $builder->add($filter, $filter, $options);
        }
    }

    /**
     * Set the options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'listing_id'   => null,
            'widget'   => null,
            'filters'   => array(),
        ));
    }

    /**
     * get form name
     *
     * @return String The name of the form
     */
    public function getName()
    {
        return 'victoire_form_filter';
    }
}
