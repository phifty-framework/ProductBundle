<?php
namespace ProductBundle;
use Phifty\Bundle;
use AdminUI\CRUDHandler;

class ProductSubsectionCRUDHandler extends CRUDHandler
{
    /* CRUD Attributes */
    public $modelClass = 'ProductBundle\Model\ProductSubsection';
    public $crudId     = 'product_subsection';

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

    // public $templatePage = '@CRUD/page.html.twig';
    // public $actionViewClass = 'AdminUI\\Action\\View\\StackView';
    // public $pageLimit = 15;
    // public $defaultOrder = array('id', 'DESC');

    public function getCollection()
    {
        return parent::getCollection();
    }


    public function getModalActionView()
    {
        $bundle = ProductBundle::getInstance();
        $skips = array('product_id');
        $view = $this->createActionView($this->currentAction,null,array(
            'submit_btn' => false,
            'close_btn' => false,
            'ajax' => true,
            'skips' => $skips,
        ));
        return $view;
    }
}

