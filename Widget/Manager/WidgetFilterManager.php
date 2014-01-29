<?php

namespace Victoire\FilterBundle\Widget\Manager;


use Victoire\FilterBundle\Form\WidgetFilterType;
use Victoire\FilterBundle\Entity\WidgetFilter;

class WidgetFilterManager
{
protected $container;

    /**
     * constructor
     *
     * @param ServiceContainer $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * create a new WidgetFilter
     * @param Page   $page
     * @param string $slot
     *
     * @return $widget
     */
    public function newWidget($page, $slot)
    {
        $widget = new WidgetFilter();
        $widget->setPage($page);
        $widget->setslot($slot);

        return $widget;
    }
    /**
     * render the WidgetFilter
     * @param Widget $widget
     *
     * @return widget show
     */
    public function render($widget)
    {
        $options = array(
            'list_id' => $widget->getList()->getId(),
            'filters' => $widget->getFilters()
        );
        $filterForm = $this->container->get('form.factory')
                           ->create('filter', null, $options);

        if ($widget->getPage()->getId() === $widget->getList()->getPage()->getId() && $widget->getAjax()) {
            $action = $this->container->get('router')->getGenerator()->generate('victoire_cms_widget_show', array('id' => $widget->getList()));
            $ajax = true;

        } else {
            $action = $this->container->get('router')->getGenerator()->generate('victoire_cms_page_show', array('url' => $widget->getList()->getPage()->getUrl()));
            $ajax = false;
        }

        return $this->container->get('victoire_templating')->render(
            "VictoireFilterBundle::show.html.twig",
            array(
                "widget" => $widget,
                "action" => $action,
                "ajax" => $ajax,
                "filterForm"  => $filterForm->createView()
            )
        );
    }

    /**
     * render WidgetFilter form
     * @param Form           $form
     * @param WidgetFilter $widget
     * @param BusinessEntity $entity
     * @return form
     */
    public function renderForm($form, $widget, $entity = null)
    {
        // print_r($form->getName());exit;
        return $this->container->get('victoire_templating')->render(
            "VictoireFilterBundle::edit.html.twig",
            array(
                "widget" => $widget,
                'form'   => $form->createView(),
                'id'     => $widget->getId(),
                'entity' => $entity
            )
        );
    }

    /**
     * create a form with given widget
     * @param WidgetFilter $widget
     * @param string         $entityName
     * @param string         $namespace
     * @return $form
     */
    public function buildForm($widget, $entityName = null, $namespace = null)
    {
        $filters = $this->container->get('victoire_cms.filter_chain')->getFilters();
        $form = $this->container->get('form.factory')->create(new WidgetFilterType($entityName, $namespace), $widget, array('filters' => $filters));

        return $form;
    }

    /**
     * create form new for WidgetFilter
     * @param Form           $form
     * @param WidgetFilter $widget
     * @param string         $slot
     * @param Page           $page
     * @param string         $entity
     *
     * @return new form
     */
    public function renderNewForm($form, $widget, $slot, $page, $entity = null)
    {

        return $this->container->get('victoire_templating')->render(
            "VictoireFilterBundle::new.html.twig",
            array(
                "widget"          => $widget,
                'form'            => $form->createView(),
                "slot"            => $slot,
                "entity"          => $entity,
                "renderContainer" => true,
                "page"            => $page
            )
        );
    }
}
