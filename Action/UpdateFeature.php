<?php

namespace ProductBundle\Action;

use Phifty\FileUtils;
use ActionKit;

class UpdateFeature extends \ActionKit\RecordAction\UpdateRecordAction
{
    public $recordClass = 'ProductBundle\Model\Feature';

    function schema() 
    {
        $this->useRecordSchema();
        $this->param('image','Image')
            ->sizeLimit( 500 )
            ->resizeWidth( ($c = \ProductBundle\ProductBundle::getInstance()->config('ProductFeature.image.resize_width') ) ?  $c : 800 )
            ->putIn( 'upload' );
    }
}

