<?php
namespace ProductBundle;
use Phifty\Bundle;
use AdminUI\CRUDHandler;

class ProductSpecTableCRUDHandler extends CRUDHandler
{
    /* CRUD Attributes */
    public $modelClass = 'ProductBundle\Model\ProductSpecTable';
    public $crudId     = 'product_spec_table';

    // public $listColumns = array( 'id', 'thumb', 'name' , 'lang' , 'subtitle' , 'sn' );
    // public $filterColumns = array();
    // public $quicksearchFields = array('name');

    public $canCreate = true;
    public $canUpdate = true;
    public $canDelete = true;

    public $canBulkEdit = true;
    public $canBulkDelete = true;
    public $canBulkCopy = false;
    public $canEditInNewWindow = false;

    // public $templatePage = '@CRUD/page.html';
    // public $actionViewClass = 'AdminUI\\Action\\View\\StackView';
    // public $pageLimit = 15;
    // public $defaultOrder = array('id', 'DESC');

    public function getCollection()
    {
        return parent::getCollection();
    }

    public $listColumns = array('id', 'title');

    public function getModalActionView()
    {
        $view = $this->createActionView($this->currentAction, null, array(
            'close_button' => false,
            'ajax' => true,
            'skips' => array('product_id'),
        ));
        return $view;
    }
}

