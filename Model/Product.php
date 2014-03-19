<?php
namespace ProductBundle\Model;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;
use ActionKit\ColumnConvert;
use SEOPlugin\SEOPage;

class Product extends \ProductBundle\Model\ProductBase implements SEOPage
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

    public function beforeUpdate($args) {
        $args['updated_on'] = date('c');
        return $args;
    }

    public function availableTypes() {
        return $this->types->filter(function($type) {
            return $type->quantity > 0;
        });
    }

    public function renderThumb($attrs = array()) {
        $html = "<img src=\"/{$this->thumb}\"" ;
        $attrs = array_merge(array(
            'title' => $this->name,
            'alt'   => $this->name,
        ), $attrs);
        foreach( $attrs as $key => $val ) {
            $html .= " $key=\"" . addslashes($val) . "\"";
        }
        $html .= "/>";
        return $html;
    }

    public function renderImage($attrs = array()) {
        $html = "<img src=\"/{$this->image}\"" ;
        foreach( $attrs as $key => $val ) {
            $html .= " $key=\"" . addslashes($val) . "\"";
        }
        $html .= "/>";
        return $html;
    }

    public function getUrl() {
        return kernel()->getBaseUrl() . sprintf('/product/%d/%s/%s', $this->id, $this->lang, rawurlencode($this->name ?: 'Untitled') );
    }

    public function getLink() {
        return sprintf('/product/%d/%s/%s', $this->id, $this->lang, rawurlencode($this->name) );
    }

    public function getMixinSchemaAction()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        if ( $mixinClass = $bundle->config('product.mixin') ) {
            return ColumnConvert::convertSchemaToAction(new $mixinClass, $this);
        }
    }

    public function getPageKeywords() {  }

    public function getPageDescription() { }

    public function getPageTitle() {
        $title = $this->name;
        if ($this->sn) {
            $title .= ' - ' . $this->sn;
        }
        return $title;
    }

}
