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

            if ( $bundle->config('ProductProperty.enable') ) {
                $data['properties'] = $record->properties->toArray();
            }
            if ( $bundle->config('ProductLink.enable') ) {
                $data['links'] = $record->links->toArray();
            }
            if ( $bundle->config('ProductImage.enable') ) {
                $data['images'] = $record->images->toArray();
            }
            if ( $bundle->config('ProductFeature.enable') ) {
                $data['features'] = $record->features->toArray();
            }
            if ( $bundle->config('ProductType.enable') ) {
                $data['types'] = $record->types->toArray();
            }
            if ( $bundle->config('ProductCategory.multicategory') ) {
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


