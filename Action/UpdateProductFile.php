<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\UpdateRecordAction;

class UpdateProductFile extends UpdateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductFile';

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $this->useRecordSchema();
        $this->param('file','File')
            ->sizeLimit( $bundle->config('file.size_limit') ?: 1024 * 10 )  // Default to 10 MB limit
            ->label('檔案')
            ->putIn( 'static/upload' );
    }
}

