<?php
namespace ProductBundle;
use Phifty\Web\RegionPager;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\Category;
use AdminUI\CRUDHandler;

class CategoryCRUDHandler extends CRUDHandler
{

    /* CRUD Attributes */
    public $modelClass = 'ProductBundle\\Model\\Category';
    public $crudId     = 'product_category';
    public $listColumns = array( 'id', 'name');
    public $canBulkEdit = true;
    public $canBulkCopy = true;

    public $listRightColumns = array(
        'updated_on',
        'created_on',
    );

    public $primaryFields = array('name');

    public $bundle;

    public function init()
    {
        $this->bundle = \ProductBundle\ProductBundle::getInstance();
        if ( $this->bundle->config('with_subcategory') ) {
            $this->setFormatter('name',function($record) {
                if ( $record->subcategories ) {
                    return "<a onclick=\" 
                        Region.of(this).refreshWith({ parent_id: {$record->id} });\"
                        href=\"#{$record->id}\">" . $record->name . '</a>';
                }
                return $record->name;
            });
        }
        parent::init();
    }

    public function getCollection()
    {
        $collection = parent::getCollection();
        if ( $this->bundle->config('with_subcategory') ) {
            $p = $this->request->param('parent_id') ?: 0;
            /* query top category */
            $collection->where(array('parent_id' => $p ));
        }
        return $collection;
    }

    public function listRegionAction()
    {
        return parent::listRegionAction();
    }
}

