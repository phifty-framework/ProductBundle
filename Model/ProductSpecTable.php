<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace ProductBundle\Model;

use ProductBundle\Model\ProductSpecTableBase;

class ProductSpecTable extends ProductSpecTableBase
{
    public function dataLabel()
    {
        return $this->title ?: "表格: {$this->id}";
    }
}
