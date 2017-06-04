<?php
namespace ProductBundle\Controller;
use Phifty\Routing\Controller;
use CommonBundle\Controller\AutoCompleteController;

class TagAutoCompleteController extends AutoCompleteController
{
    public $collectionClass = 'ProductBundle\\Model\\TagCollection';
    public $searchFields = [
        'name' => 'contains',
    ];

    public function exportCollection($collection) {
        return $collection->toLabelValuePairs();
    }
}
