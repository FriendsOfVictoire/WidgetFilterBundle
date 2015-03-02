<?php

namespace Victoire\Widget\FilterBundle\EventListener;

use Symfony\Component\Form\FormEvent;

/**
 * This class listen Filter widget form changes.
 */
class WidgetFilterFormEventListener
{
    /**
     *
     *
     * @param FormEvent $eventArgs
     */
    public function manageExtraFiltersFields(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm()->getParent();

        $form->remove('format');
        switch ($data) {
            case 'date_filter':
                $form->remove('multiple');
                $form->add('format', 'choice', array(
                    'label'   => 'widget_filter.form.date.format.label',
                    'choices' => array(
                        'year'  => 'widget_filter.form.date.format.choices.year.label',
                        'month' => 'widget_filter.form.date.format.choices.month.label',
                        'day' => 'widget_filter.form.date.format.choices.day.label',
                    ),
                ));
                break;
            case 'tag_filter':
            case 'category_filter':
                $form->add('multiple', null, array(
                    'label' => 'widget_filter.form.multiple.label',
                ));
                break;
        }
    }
}
