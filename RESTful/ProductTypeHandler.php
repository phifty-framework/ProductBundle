<?php
namespace ProductBundle\RESTful;
use CRUD\RESTful\ResourceHandler;

class ProductTypeHandler extends ResourceHandler
{
    public $recordClass = 'ProductBundle\\Model\\ProductType';

    public function load($id) {
        $record = $this->createModel();
        $ret = $record->load($id);
        if ( $ret->success ) {
            $bundle = \ProductBundle\ProductBundle::getInstance();
            return $record->toArray();
        }
        $this->codeForbidden();
        die($ret->message);
    }

}


