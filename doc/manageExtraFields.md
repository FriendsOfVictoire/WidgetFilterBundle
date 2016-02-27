
#Manage Extrafields for filter

When you create a filter, sometimes you need to set some specific configuration. To handle this feature events are throw to add fields to your form.

``victoire.widget_filter.form.pre_set_data``
and
``victoire.widget_filter.form.pre_submit``

For example you have a TextFilterType filter:

You have to declare your Event Listener :

```php
    <?php
    namespace MyAwesomeBundle\EventListener;

    use Symfony\Component\Form\FormEvent;
    use Symfony\Component\Form\Extension\Core\Type\TextType
    
    /**
     * This class is an example to add listen on Filter widget form changes.
     */
    class MyTextFilterExtraFieldsEventListener
    {
        /**
         *
         * @param FormEvent $eventArgs
         */
        public function manageExtraFiltersFields(FormEvent $event)
        {
            $data = $event->getData();
            $form = $event->getForm()->getParent();
    
            switch ($data) {
                case TextFilterType:
                    $form->add('defaultValue', TextType::class, array(
                        "data" => "My default value"
                    ));
                    break;
            }
        }
    }
```

And Add in your services :

```yml
    victoire.widget_filter.text_filter.form.listener.presetdata:
        class: MyAwesomeBundle\EventListener\MyTextFilterExtraFieldsEventListener
        arguments:
            - "@doctrine.orm.entity_manager"
        tags:
            - { name: kernel.event_listener, event: victoire.widget_filter.form.pre_set_data, method: manageExtraFiltersFields, priority: 1 }

    victoire.widget_filter.text_filter.form.listener.presubmit:
        class: MyAwesomeBundle\EventListener\MyTextFilterExtraFieldsEventListener
        arguments:
            - "@doctrine.orm.entity_manager"
        tags:
            - { name: kernel.event_listener, event: victoire.widget_filter.form.pre_submit, method: manageExtraFiltersFields, priority: 1 }
```

You can now for example add your logic in your filter: 

```php
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //For the moment default value must be set to request
        if ($this->request->query->has('filter') && array_key_exists('text_filter', $this->request->query->get('filter'))) {
            $this->request->query->replace(
                array(
                    'filter' => array(
                        $this->getName() => array(
                            'title' => $options['widget']->getDefaultValue()
                        ),
                    'listing' => $options['widget']->getListing()->getId()
                    )
                )
            );
        }
        $builder
            ->add(
                'title', TextType::class, array(
                    'data' => $options['widget']->getDefaultValue()
                )
            );
        }
    }
```
