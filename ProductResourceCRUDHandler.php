<?php
namespace ProductBundle;

class ProductResourceCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\Resource';
    public $crudId     = 'product_resource';
    public $listColumns = array('id', 'name');

    public function getDialogActionView()
    {
        $view = $this->createActionView($this->currentAction,null,array(
            'close_button' => false, 
            'ajax' => true,
            'skips' => array('product_id')
        ));
        return $view;
    }
}

