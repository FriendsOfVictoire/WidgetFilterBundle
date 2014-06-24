<?php

namespace Victoire\Widget\FilterBundle\Widget\Manager;


use Victoire\Widget\FilterBundle\Form\WidgetFilterType;
use Victoire\Widget\FilterBundle\Entity\WidgetFilter;


use Victoire\Bundle\CoreBundle\Widget\Managers\BaseWidgetManager;
use Victoire\Bundle\CoreBundle\Entity\Widget;
use Victoire\Bundle\CoreBundle\Widget\Managers\WidgetManagerInterface;

use Victoire\Bundle\PageBundle\Entity\BasePage;

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
     * Get the static content of the widget
     *
     * @param Widget $widget
     * @return string The static content
     *
     * @throws Exception
     *
     * @SuppressWarnings checkUnusedFunctionParameters
     */
    protected function getWidgetStaticContent(Widget $widget)
    {
        $widgetListing = $widget->getListing();

        if ($widgetListing === null) {
            throw new \Exception('The widget ['.$widget->getId().'] has no widgetListing.');
        }

        $options = array(
            'listing_id' => $widgetListing->getId(),
            'filters' => $widget->getFilters()
        );

        $formFactory = $this->container->get('form.factory');
        $router = $this->container->get('router');
        $routerGenerator = $router->getGenerator();
        $filterForm = $formFactory->create('victoire_form_filter', null, $options);

        if ($widget->getPage()->getId() === $widgetListing->getPage()->getId() && $widget->getAjax()) {
            $action = $routerGenerator->generate('victoire_core_widget_show', array('id' => $widgetListing->getId()));
            $ajax = true;
        } else {
            $action = $routerGenerator->generate('victoire_core_page_show', array('url' => $widgetListing->getPage()->getUrl()));
            $ajax = false;
        }

        $content = array(
            "widget" => $widget,
            "action" => $action,
            "ajax" => $ajax,
            "filterForm"  => $filterForm->createView()
        );

        return $content;
    }


    /**
     * create a form with given widget
     * @param WidgetRedactor $widget
     * @param BasePage       $page
     * @param string         $entityName
     * @param string         $namespace
     * @param boolean        $mode
     *
     * @return $form
     *
     * @throws \Exception
     */
    public function buildWidgetForm($widget, BasePage $page, $entityName = null, $namespace = null, $mode = Widget::MODE_STATIC)
    {
        //test parameters
        if ($entityName !== null) {
            if ($namespace === null) {
                throw new \Exception('The namespace is mandatory if the entityName is given');
            }
        }

        $container = $this->container;
        $formFactory = $container->get('form.factory');

        $formAlias = 'victoire_widget_form_'.strtolower($this->getWidgetName());

        $filters = $this->container->get('victoire_core.filter_chain')->getFilters();

        $form = $formFactory->create($formAlias, $widget,
            array(
                'entityName' => $entityName,
                'namespace' => $namespace,
                'mode' => $mode,
                'filters' => $filters
            )
        );

        return $form;
    }
}
