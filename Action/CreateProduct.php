<?php
namespace ProductBundle\Action;

use ActionKit;
use Phifty\FileUtils;
use ProductBundle\Model\ProductImage;
use ProductBundle\Model\Feature;
use ProductBundle\Model\Resource;
use ProductBundle\Model\FeatureRel;
use ActionKit\RecordAction\CreateRecordAction;
use ProductBundle\Model\Product;

class CreateProduct extends CreateRecordAction
{
    public $recordClass = Product::class;

    public function mixins()
    {
        return array(new ProductBaseMixin($this));
    }

    public function successMessage($ret)
    {
        return __('產品 %1 建立成功', $this->record->dataLabel());
    }
}
