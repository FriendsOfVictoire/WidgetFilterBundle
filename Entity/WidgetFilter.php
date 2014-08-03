<?php
namespace Victoire\Widget\FilterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\CoreBundle\Entity\Widget;

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
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id", onDelete="CASCADE")
     *
     */
    protected $listing;

    /**
     * filters
     * @ORM\Column(name="filters", type="array")
     */
    protected $filters;

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
     * Set filters
     * @param string $filters
     *
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

}
