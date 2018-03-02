<?php

namespace Victoire\Widget\FilterBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Victoire\Bundle\WidgetBundle\Event\WidgetFormCreateEvent;
use Victoire\Bundle\WidgetBundle\Event\WidgetFormEvents;
use Victoire\Bundle\WidgetBundle\Event\WidgetFormPreCreateEvent;
use Victoire\Widget\FilterBundle\Form\WidgetFilterFormEvents;

/**
 * Class WidgetFormFilterSubscriber.
 */
class WidgetFormFilterSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $filters;

    /**
     * WidgetFormFilterSubscriber constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public static function getSubscribedEvents()
    {
        return [
            WidgetFormEvents::PRE_CREATE.'_FILTER'      => 'addOptions',
            WidgetFilterFormEvents::PRE_SUBMIT_WIDGET   => 'addDynamicFieldsPreSubmitWidget',
            WidgetFilterFormEvents::PRE_SET_DATA_WIDGET => 'addDynamicFieldsPreSetDataWidget',
        ];
    }

    /**
     * @param WidgetFormCreateEvent $event
     */
    public function addOptions(WidgetFormPreCreateEvent $event)
    {
        $event->optionsContainer->add('filters', $this->filters);
    }

    /**
     * @param FormEvent $event
     */
    public function addDynamicFieldsPreSetDataWidget(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $this->addDynamicFields($form, $data->getMultiple());
    }

    /**
     * @param FormEvent $event
     */
    public function addDynamicFieldsPreSubmitWidget(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $this->addDynamicFields($form, array_key_exists('multiple', $data) ? $data['multiple'] : false);
    }

    /**
     * @param FormInterface $form
     * @param bool          $multiple
     */
    private function addDynamicFields(FormInterface $form, $multiple)
    {
        if ($form->has('multiple')) {
            if (true === $multiple) {
                $form->add('strict', null, [
                    'label' => 'widget_filter.form.strict.label',
                ]);
            } else {
                $form->remove('strict');
            }
        }
    }
}
