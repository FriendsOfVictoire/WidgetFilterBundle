<?php
namespace Victoire\FilterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\CmsBundle\Entity\Widget;

/**
 * WidgetFilter
 *
 * @ORM\Table("cms_widget_filter")
 * @ORM\Entity
 */
class WidgetFilter extends Widget
{
    use \Victoire\CmsBundle\Entity\Traits\WidgetTrait;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Victoire\ListBundle\Entity\WidgetList", inversedBy="items")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id", onDelete="CASCADE")
     *
     */
    private $list;

    /**
     * filters
     * @ORM\Column(name="filters", type="array")
     */
    private $filters;

    /**
     * ajax
     * @ORM\Column(name="ajax", type="boolean")
     */
    private $ajax = true;

    /**
     * Set list
     *
     * @param string $list
     * @return WidgetFilter
     */
    public function setList($list)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return string
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set filters
     *
     * @param string $filters
     * @return FilterWidget
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get filters
     *
     * @return string
     */
    public function getFilters()
    {
        return $this->filters;
    }
    /**
     * Set ajax
     *
     * @param string $ajax
     * @return FilterWidget
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * Get ajax
     *
     * @return string
     */
    public function getAjax()
    {
        return $this->ajax;
    }

}

