<?php

namespace Victoire\Widget\FilterBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Victoire\Widget\FilterBundle\Form\WidgetFilterFormEvents;

/**
 * Class WidgetFormFilterSubscriber.
 */
class WidgetFormFilterSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return [
            WidgetFilterFormEvents::PRE_SUBMIT_WIDGET   => 'addDynamicFieldsPreSubmitWidget',
            WidgetFilterFormEvents::PRE_SET_DATA_WIDGET => 'addDynamicFieldsPreSetDataWidget',
        ];
    }

    public function addDynamicFieldsPreSetDataWidget(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $this->addDynamicFields($form, $data->getMultiple());
    }

    public function addDynamicFieldsPreSubmitWidget(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $this->addDynamicFields($form, array_key_exists('multiple', $data) ? $data['multiple'] : false);
    }

    private function addDynamicFields($form, $multiple)
    {
        if ($form->has('multiple')) {
            if ($multiple) {
                $form
                    ->add('strict', null, [
                        'label' => 'widget_filter.form.strict.label',
                    ]);
            } else {
                $form->remove('strict');
            }
        }
    }
}
