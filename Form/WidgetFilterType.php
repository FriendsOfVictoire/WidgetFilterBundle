<?php

namespace Victoire\Widget\FilterBundle\Form;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\FilterBundle\Filter\BaseFilter;

/**
 * WidgetFilter form type.
 */
class WidgetFilterType extends WidgetType
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [];
        foreach ($options['filters'] as $filter) {
            /* @var BaseFilter $filter */
            $choices['widget_filter.'.$filter->getName()] = get_class($filter);
        }

        $builder->add('listing', null, [
                    'label' => 'widget_filter.form.list.label',
                ])
                ->add('filter', ChoiceType::class, [
                    'label'             => 'widget_filter.form.filters.label',
                    'choices'           => $choices,
                    'choices_as_values' => true,
                    'attr'              => [
                        'data-refreshOnChange' => 'true',
                    ],
                ])
                ->add('ajax', null, [
                    'label' => 'widget_filter.form.ajax.label',
                ])
                ->add('multiple', null, [
                    'label' => 'widget_filter.form.multiple.label',
                    'attr'  => [
                        'data-refreshOnChange' => 'true',
                    ],
                ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $this->eventDispatcher->dispatch(WidgetFilterFormEvents::PRE_SET_DATA_WIDGET, $event);
        });

        $builder->get('filter')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $this->eventDispatcher->dispatch(WidgetFilterFormEvents::PRE_SET_DATA, $event);
        });

        // manage conditional relatedView type in pre submit (ajax call to refresh view)
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $this->eventDispatcher->dispatch(WidgetFilterFormEvents::PRE_SUBMIT_WIDGET, $event);
        });
        $builder->get('filter')->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $this->eventDispatcher->dispatch(WidgetFilterFormEvents::PRE_SUBMIT, $event);
        });

        //add the mode to the form
        $builder->add('mode', HiddenType::class, [
            'data' => $options['mode'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\FilterBundle\Entity\WidgetFilter',
            'widget'             => 'filter',
            'filters'            => [],
            'translation_domain' => 'victoire',
        ]);
    }
}
