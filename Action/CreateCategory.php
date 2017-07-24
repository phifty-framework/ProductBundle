<?php
namespace ProductBundle\Action;

use WebAction;
use Phifty\FileUtils;
use WebAction\RecordAction\CreateRecordAction;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryFile;

class CreateCategory extends CreateRecordAction
{
    public $recordClass = Category::class;

    public $nested = true;

    public function successMessage($ret)
    {
        return _('產品類別新增成功');
    }
}
