<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;

class CategoryFileCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\CategoryFile';
    public $crudId     = 'product_category_file';
    public $listColumns = array('id', 'title','file');

    public function getModalActionView()
    {
        return $this->createActionView($this->currentAction,null,array(
            'close_btn' => false, 
            'ajax' => true,
            'skips' => array('category_id','mimetype'),
        ));
    }
}

