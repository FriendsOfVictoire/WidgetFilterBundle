<?php

namespace Victoire\Widget\FilterBundle\Widget\Manager;


use Victoire\Widget\FilterBundle\Form\WidgetFilterType;
use Victoire\Widget\FilterBundle\Entity\WidgetFilter;


use Victoire\Bundle\CoreBundle\Widget\Managers\BaseWidgetManager;
use Victoire\Bundle\CoreBundle\Entity\Widget;
use Victoire\Bundle\CoreBundle\Widget\Managers\WidgetManagerInterface;

/**
 * CRUD operations on WidgetRedactor Widget
 *
 * The widget view has two parameters: widget and content
 *
 * widget: The widget to display, use the widget as you wish to render the view
 * content: This variable is computed in this WidgetManager, you can set whatever you want in it and display it in the show view
 *
 * The content variable depends of the mode: static/businessEntity/entity/query
 *
 * The content is given depending of the mode by the methods:
 *  getWidgetStaticContent
 *  getWidgetBusinessEntityContent
 *  getWidgetEntityContent
 *  getWidgetQueryContent
 *
 * So, you can use the widget or the content in the show.html.twig view.
 * If you want to do some computation, use the content and do it the 4 previous methods.
 *
 * If you just want to use the widget and not the content, remove the method that throws the exceptions.
 *
 * By default, the methods throws Exception to notice the developer that he should implements it owns logic for the widget
 *
 */
class WidgetFilterManager extends BaseWidgetManager implements WidgetManagerInterface
{
    /**
     * The name of the widget
     *
     * @return string
     */
    public function getWidgetName()
    {
        return 'Filter';
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
            $action = $this->container->get('router')->getGenerator()->generate('victoire_core_widget_show', array('id' => $widget->getList()));
            $ajax = true;

        } else {
            $action = $this->container->get('router')->getGenerator()->generate('victoire_core_page_show', array('url' => $widget->getList()->getPage()->getUrl()));
            $ajax = false;
        }

        return $this->container->get('victoire_templating')->render(
            "VictoireWidgetFilterBundle::show.html.twig",
            array(
                "widget" => $widget,
                "action" => $action,
                "ajax" => $ajax,
                "filterForm"  => $filterForm->createView()
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
        $filters = $this->container->get('victoire_core.filter_chain')->getFilters();
        $form = $this->container->get('form.factory')->create(new WidgetFilterType($entityName, $namespace), $widget, array('filters' => $filters));

        return $form;
    }
}
