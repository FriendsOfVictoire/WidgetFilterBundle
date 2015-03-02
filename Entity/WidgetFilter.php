<?php
namespace Victoire\Widget\FilterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetFilter
 *
 * @ORM\Table("vic_widget_filter")
 * @ORM\Entity
 */
class WidgetFilter extends Widget
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Victoire\Widget\ListingBundle\Entity\WidgetListing", inversedBy="items")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id", onDelete="SET NULL")
     *
     */
    protected $listing;

    /**
     * filter
     * @ORM\Column(name="filter", type="string", length=55, nullable=true)
     */
    protected $filter;

    /**
     * filter
     * @ORM\Column(name="format", type="string", length=55, nullable=true)
     */
    protected $format;

    /**
     * @ORM\Column(name="multiple", type="boolean")
     */
    protected $multiple = true;

    /**
     * ajax
     * @ORM\Column(name="ajax", type="boolean")
     */
    protected $ajax = true;

    /**
     * Set list
     * @param string $listing
     *
     * @return WidgetFilter
     */
    public function setListing($listing)
    {
        $this->listing = $listing;

        return $this;
    }

    /**
     * Get listing
     *
     * @return string
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * Set filter
     * @param string $filter
     *
     * @return FilterWidget
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }
    /**
     * Set ajax
     * @param string $ajax
     *
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

    /**
     * Get multiple
     *
     * @return string
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set multiple
     * @param string $multiple
     *
     * @return $this
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set format
     * @param string $format
     *
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }
}
