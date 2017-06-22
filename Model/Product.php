<?php
namespace ProductBundle\Model;

use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;
use WebAction\ColumnConvert;

class Product extends \ProductBundle\Model\ProductBase
{
    public function dataLabel()
    {
        /*
        if ( $this->lang ) {
            return '[' . _($this->lang) . '] ' .  $this->name;
        }
        */
        return $this->name;
    }

    public function getFirstCategory()
    {
        if (isset($this->categories) && $this->categories) {
            return $this->categories->first();
        } elseif ($this->category) {
            return $this->category;
        }
    }

    public function availableTypes()
    {
        return $this->types->filter(function ($type) {
            return $type->quantity > 0;
        });
    }

    public function renderThumb($attrs = array())
    {
        $html = "<img src=\"/{$this->thumb}\"" ;
        $attrs = array_merge(array(
            'title' => $this->name,
            'alt'   => $this->name,
        ), $attrs);
        foreach ($attrs as $key => $val) {
            $html .= " $key=\"" . addslashes($val) . "\"";
        }
        $html .= "/>";
        return $html;
    }

    public function renderImage($attrs = array())
    {
        $html = "<img src=\"/{$this->image}\"" ;
        foreach ($attrs as $key => $val) {
            $html .= " $key=\"" . addslashes($val) . "\"";
        }
        $html .= "/>";
        return $html;
    }

    public function getUrl($absolute = false)
    {
        if ($absolute) {
            return kernel()->getBaseUrl() . sprintf('/product/%d/%s/%s', $this->id, $this->lang, rawurlencode($this->name ? str_replace('/', '', $this->name) : 'Untitled'));
        }
        return sprintf('/product/%d/%s/%s', $this->id, $this->lang, rawurlencode($this->name ? str_replace('/', '', $this->name) : 'Untitled'));
    }

    public function getLink()
    {
        return sprintf('/product/%d/%s/%s', $this->id, $this->lang, rawurlencode(str_replace('/', '', $this->name)));
    }

    public function getMixinSchemaAction()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        if ($mixinClass = $bundle->config('product.mixin')) {
            return ColumnConvert::convertSchemaToAction(new $mixinClass, $this);
        }
    }

    public function getPageKeywords()
    {
    }

    public function getPageDescription()
    {
    }

    public function getPageTitle()
    {
        $title = $this->name;
        if ($this->sn) {
            $title .= ' - ' . $this->sn;
        }
        return $title;
    }


    public function getAllCategories()
    {
        $cates = array();
        foreach ($this->categories as $c) {
            $parentCategories = $c->getAllParentCategories();
            $cates = $cates + $parentCategories;
        }
        return $cates;
    }

    /**
     * Check if this product is in a specific category by the handle string.
     *
     * @param string $handle
     */
    public function isInCategoryByHandle($handle)
    {
        foreach ($this->categories as $c) {
            if ($c->handle && $c->handle === $handle) {
                return true;
            }
            $pcs = $c->getAllParentCategories();
            foreach ($pcs as $pc) {
                if ($pc->handle && $pc->handle === $handle) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return bool check price and sellable flag.
     */
    public function isSellable()
    {
        return $this->sellable && $this->price > 0;
    }


    protected $_allSoldOut;

    public function isAllSoldOut()
    {
        if ($this->_allSoldOut !== null) {
            return $this->_allSoldOut;
        }
        return $this->_allSoldOut = ! $this->types->quantityAvailable();
    }
}
