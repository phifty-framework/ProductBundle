<?php
namespace ProductBundle\Action;

use ActionKit\RecordAction\CreateRecordAction;
use ProductBundle\Model\ProductType;

class CreateProductType extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductType';

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = kernel()->bundle('ProductBundle');
        $autoResize = $bundle->config('auto_resize');
        $iconSize = $bundle->config('ProductType.icon.size');
        $iconSizeLimit = $bundle->config('ProductType.icon.size_limit');
        $iconResizeWidth = $bundle->config('ProductType.icon.resize_width') ?: 0;
        if ($bundle->config('ProductType.icon')) {
            $this->param('icon', 'Image')
                ->size($iconSize)
                ->autoResize($autoResize)
                ->resizeWidth($iconResizeWidth)
                ->label('圖示')
                ->hint($bundle->config('ProductType.icon.hint'))
                ->hintFromSizeInfo()
                ;
        }
    }

    public function run()
    {
        // kernel()->db->query("LOCK TABLES " . ProductType::table . " AS m WRITE");
        $ret = parent::run();
        // kernel()->db->query("UNLOCK TABLES");
        return $ret;
    }

    public function successMessage($ret)
    {
        return _('成功建立產品類型');
    }
}
