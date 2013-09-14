<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;

class CategoryFileCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\CategoryFile';
    public $crudId     = 'product_category_file';
    public $listColumns = array('id', 'title','file');

    public function getDialogActionView()
    {
        return $this->createActionView($this->currentAction,null,array(
            'close_button' => false, 
            'ajax' => true,
            'skips' => array('category_id','mimetype'),
        ));
    }
}

