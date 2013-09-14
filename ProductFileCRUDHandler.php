<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;

class ProductFileCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\ProductFile';
    public $crudId     = 'product_file';
    public $listColumns = array('id', 'title','file');

    public function getDialogActionView()
    {
        $view = $this->createActionView($this->currentAction,null,array(
            'close_button' => false, 
            'ajax' => true,
            'skips' => array('product_id','mimetype'),
        ));
        return $view;
    }
}

