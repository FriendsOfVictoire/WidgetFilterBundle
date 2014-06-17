<?php
namespace Victoire\Widget\FilterBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\QueryBuilder;
use Victoire\Widget\FilterBundle\Filter\BaseFilterInterface;

abstract class BaseFilter extends AbstractType implements BaseFilterInterface
{
    public function buildQuery(QueryBuilder &$qb, array $parameters)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    public function getName()
    {
    }

}
