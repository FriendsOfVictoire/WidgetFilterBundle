<?php

namespace Victoire\Widget\FilterBundle\Form;

/**
 *
 */
final class WidgetFilterFormEvents
{
    /**
     * The PRE_SUBMIT event is dispatched at the beginning of the Form::submit() method.
     *
     * It can be used to:
     *  - Change data from the request, before submitting the data to the form.
     *  - Add or remove form fields, before submitting the data to the form.
     * The event listener method receives a Symfony\Component\Form\FormEvent instance.
     *
     * @Event
     */
    const PRE_SUBMIT = 'victoire.widget_filter.form.pre_submit';
    const PRE_SUBMIT_WIDGET = 'victoire.widget_filter.widget.form.pre_submit';

    /**
     * The FormEvents::PRE_SET_DATA event is dispatched at the beginning of the Form::setData() method.
     * The FormEvents::PRE_SET_DATA_widget event is dispatched at the beginning of the Form::setData() method.
     *
     * It can be used to:
     *  - Modify the data given during pre-population;
     *  - Modify a form depending on the pre-populated data (adding or removing fields dynamically).
     * The event listener method receives a Symfony\Component\Form\FormEvent instance.
     *
     * @Event
     */
    const PRE_SET_DATA = 'victoire.widget_filter.form.pre_set_data';
    const PRE_SET_DATA_WIDGET = 'victoire.widget_filter.widget.form.pre_set_data';
}
