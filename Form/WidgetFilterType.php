<?php

namespace Victoire\Widget\FilterBundle\Form;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;

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
            $choices[$filter->getName()] = 'widget_filter.'.$filter->getName();
        }

        $builder->add('listing', null, [
                    'label' => 'widget_filter.form.list.label',
                ])
                ->add('filter', 'choice', [
                    'label'   => 'widget_filter.form.filters.label',
                    'choices' => $choices,
                    'attr'    => [
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

        $mode = $options['mode'];

        //add the mode to the form
        $builder->add('mode', 'hidden', [
            'data' => $mode,
        ]);
    }

    /**
     * bind form to WidgetRedactor entity.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\FilterBundle\Entity\WidgetFilter',
            'widget'             => 'filter',
            'filters'            => [],
            'translation_domain' => 'victoire',
        ]);
    }

    /**
     * get form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'victoire_widget_form_filter';
    }
}
