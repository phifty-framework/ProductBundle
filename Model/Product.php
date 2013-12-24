<?php
namespace ProductBundle\Model;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;

class Product 
extends \ProductBundle\Model\ProductBase
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

    public function availableTypes() {
        return $this->types->filter(function($type) {
            return $type->quantity > 0;
        });
    }

}
