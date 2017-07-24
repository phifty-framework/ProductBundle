<?php
namespace ProductBundle\Action;

use Phifty\FileUtils;
use WebAction\RecordAction\UpdateRecordAction;
use ProductBundle\Model\Category;

class UpdateCategory extends UpdateRecordAction
{
    public $recordClass = Category::class;

    public $nested = true;

    public function successMessage($ret)
    {
        return '產品類別更新成功。';
    }
}
