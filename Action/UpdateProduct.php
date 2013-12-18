<?php
namespace ProductBundle\Action;

use Phifty\FileUtils;
use ActionKit;
use ProductBundle\Model\ProductImage;
use ProductBundle\Model\Feature;
use ProductBundle\Model\Resource;
use ProductBundle\Model\FeatureRel;

class UpdateProduct extends \ActionKit\RecordAction\UpdateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';

    public function mixins() {
        return array(new ProductBaseMixin($this));
    }

    public function successMessage($ret)
    {
        return __('產品 %1 更新成功', $this->record->dataLabel() );
    }
}

