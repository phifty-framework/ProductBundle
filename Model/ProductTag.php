<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace ProductBundle\Model;

use ProductBundle\Model\ProductTagBase;

class ProductTag extends ProductTagBase
{
    public function dataLabel()
    {
        if ($this->tag_id) {
            return $this->tag->name;
        }
    }
}
