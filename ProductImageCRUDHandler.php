<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;

class ProductImageCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\ProductImage';
    public $crudId     = 'product_image';
    public $listColumns = array('id', 'title');

    public function getModalActionView()
    {
        $bundle = ProductBundle::getInstance();
        $skips = array('product_id');
        if( ! $bundle->config('ProductImage.large') ) {
            // skip large image field (which is for zooming)
            $skips[] = 'large';
        }
        $view = $this->createActionView($this->currentAction,null,array(
            'submit_btn' => false,
            'close_btn' => false,
            'ajax' => true,
            'skips' => $skips,
        ));
        return $view;
    }
}

