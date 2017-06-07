<?php
namespace ProductBundle;
use Phifty\Web\RegionPager;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\Category;
use AdminUI\CRUDHandler;

class CategoryCRUDHandler extends CRUDHandler
{

    /* CRUD Attributes */
    public $modelClass = Category::class;

    public $parentKeyRecordClass = Category::class;

    public $parentKeyField = 'parent_id';

    public $crudId     = 'product_category';

    public $listColumns = ['id', 'name'];

    public $canBulkEdit = true;

    public $canBulkCopy = true;

    public $listRightColumns = [
        'updated_on',
        'created_on',
    ];

    public $primaryFields = ['name'];

    public function getCollection()
    {
        $collection = parent::getCollection();
        if ($this->bundle->config('ProductCategory.subcategory') ) {
            $p = $this->request->param($this->parentKeyField) ?: 0;
            $collection->where(array('parent_id' => $p ));
        }
        return $collection;
    }

    public function listRegionAction()
    {
        return parent::listRegionAction();
    }
}

