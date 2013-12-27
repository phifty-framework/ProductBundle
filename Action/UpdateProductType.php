<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\UpdateRecordAction;
use ProductBundle\Model\ProductType;

class UpdateProductType extends UpdateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductType';

    public function run() {
        kernel()->db->query("LOCK TABLES " . ProductType::table . " AS m WRITE");
        $ret = parent::run();
        kernel()->db->query("UNLOCK TABLES");
        return $ret;
    }

    public function successMessage($ret) {
        return _('成功更新產品類型');
    }

}


