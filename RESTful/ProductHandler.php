<?php
namespace ProductBundle\RESTful;

use CRUD\Controller\RESTfulResourceController;

class ProductHandler extends RESTfulResourceController
{
    public $recordClass = 'ProductBundle\\Model\\Product';

    public function loadAction($id)
    {
        $record = $this->recordClass::load($id);
        if (!$record) {
            return [404, ['Content-Type: application/json;'], json_encode(['message' => 'record not found.'], JSON_PRETTY_PRINT) ];
        }

        $bundle = \ProductBundle\ProductBundle::getInstance();
        $data = $record->toArray();
        if ($bundle->config('ProductProperty.enable')) {
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
        if ( $bundle->config('Category.multicategory') ) {
            $data['categories'] = $record->categories->toArray();
        } else {
            $data['category'] = $record->category ? $record->category->toArray() : array();
        }
        return [200, ['Content-Type: application/json;'], json_encode($data, JSON_PRETTY_PRINT) ];
    }
}
