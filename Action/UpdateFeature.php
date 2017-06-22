<?php

namespace ProductBundle\Action;

use Phifty\FileUtils;
use WebAction;

class UpdateFeature extends \WebAction\RecordAction\UpdateRecordAction
{
    public $recordClass = 'ProductBundle\Model\Feature';

    public function schema()
    {
        $this->useRecordSchema();
        $this->param('image', 'Image')
            ->sizeLimit(500)
            ->resizeWidth(($c = \ProductBundle\ProductBundle::getInstance()->config('ProductFeature.image.resize_width')) ?  $c : 800)
            ->putIn('upload');
    }
}
