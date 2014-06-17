<?php

namespace Victoire\Widget\FilterBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\EntityProxyFormType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;



/**
 * Filter type
 */
class FilterType extends AbstractType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('list', 'hidden', array(
                'data' => $options['list_id']
            ));

        foreach ($options['filters'] as $filter) {
            $builder->add($filter, $filter);
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
            'list_id'   => null,
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
