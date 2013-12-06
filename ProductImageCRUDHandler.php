<?php
namespace ProductBundle;
use AdminUI\CRUDHandler;

class ProductImageCRUDHandler extends CRUDHandler
{
    public $modelClass = 'ProductBundle\\Model\\ProductImage';
    public $crudId     = 'product_image';
    public $listColumns = array('id', 'title');

    public function getDialogActionView()
    {
        $bundle = ProductBundle::getInstance();
        $skips = array('product_id');
        if( ! $bundle->config('with_zoom_image') ) {
            // skip large image field (which is for zooming)
            $skips[] = 'large';
        }
        $view = $this->createActionView($this->currentAction,null,array(
            'close_button' => false, 
            'ajax' => true,
            'skips' => $skips,
        ));
        return $view;
    }
}

