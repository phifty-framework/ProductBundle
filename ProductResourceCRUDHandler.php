<?php
namespace ProductBundle;

class ProductResourceCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\Resource';
    public $crudId     = 'product_resource';
    public $listColumns = array('id', 'name');

    public function getModalActionView()
    {
        $view = $this->createActionView($this->currentAction,null,array(
            'submit_btn' => false,
            'close_btn' => false, 
            'ajax' => true,
            'skips' => array('product_id')
        ));
        return $view;
    }
}

