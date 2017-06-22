<?php
namespace ProductBundle\Action;

use WebAction\Action;
use WebAction\RecordAction\CreateRecordAction;

class CreateProductSpecTable extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductSpecTable';

    public function run()
    {
        if ($ret = parent::run()) {
            return $this->success($this->successMessage($ret), $this->getRecord()->getData());
        }
        return $this->error('系統錯誤');
    }
}
