<?php

namespace Victoire\FilterBundle\Filter;

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
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
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
     * {@inheritdoc}
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
     */
    public function getName()
    {
        return 'filter';
    }
}
