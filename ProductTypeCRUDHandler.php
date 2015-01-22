<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;
use ProductBundle\ProductBundle;

class ProductTypeCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\ProductType';
    public $crudId     = 'product_type';
    public $listColumns = array('id', 'title');

    public function getModalActionView()
    {
        $view = $this->createActionView($this->currentAction,null,array(
            'close_button' => false,
            'submit_button' => false,
            'ajax' => true,
            'skips' => array('product_id'),
        ));
        return $view;
    }
}
