<?php
namespace ProductBundle\Action;
use ActionKit;
use ActionKit\RecordAction\CreateRecordAction;
use Phifty\FileUtils;

class CreateFeature extends CreateRecordAction
{
    public $recordClass = '\ProductBundle\Model\Feature';

    function schema() 
    { 
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'static/upload';

        $this->param('image','Image')
            ->sizeLimit( ($c=$bundle->config('image.size_limit')) ? $c : 600 )
            ->resizeWidth( ($c = $bundle->config('image.resize_width') ) ?  $c : 800 )
            ->putIn( $uploadDir );
    }
}

