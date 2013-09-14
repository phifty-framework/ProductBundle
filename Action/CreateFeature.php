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
        $plugin = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$plugin->config('upload_dir')) ? $c : 'static/upload';

        $this->param('image','Image')
            ->sizeLimit( ($c=$plugin->config('image.size_limit')) ? $c : 600 )
            ->resizeWidth( ($c = $plugin->config('image.resize_width') ) ?  $c : 800 )
            ->putIn( $uploadDir );
    }
}

