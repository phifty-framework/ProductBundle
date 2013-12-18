<?php
namespace ProductBundle\RESTful;
use CRUD\RESTful\ResourceHandler;

class ProductHandler extends ResourceHandler
{
    public $recordClass = 'ProductBundle\\Model\\Product';

    public function load($id) {
        $record = $this->createModel();
        $ret = $record->load($id);
        if ( $ret->success ) {
            $bundle = \ProductBundle\ProductBundle::getInstance();
            $data = $record->toArray();

            if ( $bundle->config('with_properties') ) {
                $data['properties'] = $record->properties->toArray();
            }
            if ( $bundle->config('with_images') ) {
                $data['images'] = $record->images->toArray();
            }
            if ( $bundle->config('with_features') ) {
                $data['features'] = $record->features->toArray();
            }
            if ( $bundle->config('with_types') ) {
                $data['types'] = $record->types->toArray();
            }
            if ( $bundle->config('with_multicategory') ) {
                $data['categories'] = $record->categories->toArray();
            } else {
                $data['category'] = $record->category ? $record->category->toArray() : array();
            }
            return $data;
        }
        $this->codeForbidden();
        die($ret->message);
    }

}


