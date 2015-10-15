<?php

namespace Victoire\Widget\FilterBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;

/**
 */
class WidgetFilterSetDefaultValueEvent extends Event
{
    private $form;
    protected $data;
    private $businessEntityId;

    /**
     * Constructs an event.
     *
     * @param FormInterface $form The associated form
     * @param mixed         $data The data
     */
    public function __construct(FormInterface $form, $data)
    {
        $this->form = $form;
        $this->data = $data;
        if ($form->getData()->getListing()) {
            $this->businessEntityId = $form->getData()->getListing()->getBusinessEntityId();
        }
    }

    /**
     * Returns the form at the source of the event.
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Returns the data associated with this event.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Allows updating with some filtered data.
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get businessEntityId.
     *
     * @return string
     */
    public function getBusinessEntityId()
    {
        return $this->businessEntityId;
    }

    /**
     * Set businessEntityId.
     *
     * @param string $businessEntityId
     *
     * @return $this
     */
    public function setBusinessEntityId($businessEntityId)
    {
        $this->businessEntityId = $businessEntityId;

        return $this;
    }
}
