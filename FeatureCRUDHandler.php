<?php
namespace ProductBundle;

class FeatureCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\Feature';
    public $crudId     = 'product_feature';
    public $listColumns = array( 'id', 'name', 'lang' );
}

