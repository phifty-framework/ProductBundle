<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use CommonBundle\Controller\AutoCompleteController;

class ProductAutoCompleteController extends AutoCompleteController
{
    public $collectionClass = 'ProductBundle\\Model\\ProductCollection';
    public $searchFields = [
        'name' => 'contains',
    ];
    // public $labelField = 'name';
    // public $valueField = 'id';

    public function exportCollection($collection) {
        $items = [];
        foreach( $collection as $item ) {
            $items[] = [
                'id' => $item->id,
                'label' => $item->name,
                'value' => $item->id,
                'name' => $item->name,
                'thumb' => $item->thumb,
            ];
        }
        return $items;
    }
}
