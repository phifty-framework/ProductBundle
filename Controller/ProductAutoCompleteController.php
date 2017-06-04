<?php
namespace ProductBundle\Controller;
use Phifty\Routing\Controller;
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
        return $collection->toLabelValuePairs();
    }
}
