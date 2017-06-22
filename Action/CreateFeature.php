<?php
namespace ProductBundle\Action;

use WebAction;
use WebAction\RecordAction\CreateRecordAction;
use Phifty\FileUtils;

class CreateFeature extends CreateRecordAction
{
    public $recordClass = '\ProductBundle\Model\Feature';

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'upload';

        $this->param('image', 'Image')
            ->sizeLimit(($c=$bundle->config('ProductFeature.image.size_limit')) ? $c : 600)
            ->resizeWidth(($c = $bundle->config('ProductFeature.image.resize_width')) ?  $c : 800)
            ->putIn($uploadDir);
    }
}
