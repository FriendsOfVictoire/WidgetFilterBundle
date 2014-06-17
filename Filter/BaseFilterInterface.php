<?php
namespace Victoire\Widget\FilterBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\QueryBuilder;

interface BaseFilterInterface
{
    public function buildQuery(QueryBuilder &$qb, array $parameters);
    // public function buildForm(FormBuilderInterface $builder, array $options);
    // public function setDefaultOptions(OptionsResolverInterface $resolver);
    // public function getName();
}
