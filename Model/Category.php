<?php
namespace ProductBundle\Model;
use CoreBundle\Linkable;

class Category 
extends \ProductBundle\Model\CategoryBase implements Linkable
{

    public $dataLabelField = 'name';

    public function dataLabel()
    {
        if ( $this->parent_id )
            return $this->parent->dataLabel() . ' &gt; ' . $this->name;
        return $this->name;
    }

    public function getRootCategory()
    {
        $p = $this;
        while ($p->parent_id) {
            $p = $p->parent;
        }
        return $p;
    }


    public function getAllParentCategories()
    {
        $parents = array($this);
        $p = $this;
        while ($p->parent_id) {
            $parents[] = $p->parent;
            $p = $p->parent;
        }
        return array_reverse($parents);
    }

    public function getParent()
    {
        if ($this->parent_id) {
            return $this->parent;
        }
    }

    public function getAllChildCategories($includeSelf = false)
    {
        $categories = array();
        if ($includeSelf) {
            $categories[] = $this;
        }
        if ($this->subcategories) {
            $subcategories = $this->subcategories;
            foreach ($subcategories as $subc) {
                $categories[] = $subc;
                foreach($subc->getAllChildCategories() as $subc2) {
                    $categories[] = $subc2;
                }
            }
        }
        return $categories;
    }

    public function getLink()
    {
        return "/" . join("/", array(
            "pc",
            "id",
            $this->id,
            $this->lang,
            rawurlencode($this->name ? str_replace('/','',$this->name) : 'Untitled'))
        );
    }

    public function getUrl($absolute = false)
    {
        // /pc/id/:id(/:lang/:name)
        if ($absolute) {
            return kernel()->getBaseUrl() . $this->getLink();
        }
        return $this->getLink();
    }
}
