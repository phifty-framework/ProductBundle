<?php
namespace ProductBundle\Action;

use Phifty\FileUtils;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteCategory extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Category';

    public function successMessage($ret)
    {
        return '刪除成功';
    }
}
