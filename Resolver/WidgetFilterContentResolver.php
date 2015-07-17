<?php

namespace Victoire\Widget\FilterBundle\Resolver;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Router;
use Victoire\Bundle\CoreBundle\Helper\CurrentViewHelper;
use Victoire\Bundle\WidgetBundle\Model\Widget;
use Victoire\Bundle\WidgetBundle\Resolver\BaseWidgetContentResolver;

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
class WidgetFilterContentResolver extends BaseWidgetContentResolver
{
    private $formFactory; // @form.factory
    private $router;      // @router
    private $currentView;      // @victoire_core.current_view

    public function __construct(FormFactory $formFactory, Router $router, CurrentViewHelper $currentView)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->currentView = $currentView;
    }
    /**
     * Get the static content of the widget
     *
     * @param Widget $widget
     *
     * @return string The static content
     *
     * @throws Exception
     */
    public function getWidgetStaticContent(Widget $widget)
    {
        $widgetListing = $widget->getListing();

        if ($widgetListing === null) {
            throw new \Exception('The widget ['.$widget->getId().'] has no widgetListing.');
        }

        $options = array(
            'listing_id' => $widgetListing->getId(),
            'filter'     => $widget->getFilter(),
            'multiple'   => $widget->getMultiple(),
            'widget'     => $widget,
        );

        $filterForm = $this->formFactory->create('filter', null, $options);

        if ($widget->getView()->getId() === $widgetListing->getView()->getId() && $widget->getAjax()) {
            $currentView = $this->currentView;
            $action = $this->router->generate('victoire_core_widget_show', array('id' => $widgetListing->getId(), 'viewReferenceId' => $currentView()->getReference()['id']));
            $ajax = true;
        } else {
            $action = $this->router->generate('victoire_core_page_show', array('url' => $widgetListing->getView()->getUrl()));
            $ajax = false;
        }

        $parameters = array(
            "widget" => $widget,
            "action" => $action,
            "ajax" => $ajax,
            "filterForm"  => $filterForm->createView(),
        );

        $reflect = new \ReflectionClass($widget);
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($reflect->getProperties() as $property) {
            if (!$property->isStatic()) {
                $value = $accessor->getValue($widget, $property->getName());
                $parameters[$property->getName()] = $value;
            }
        }

        return $parameters;
    }
}
