<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;

class CreateProductFile extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductFile';

    public function schema()
    {
        $plugin = \ProductBundle\ProductBundle::getInstance();
        $sizeLimit = $plugin->config('files.size_limit') ?: 1024 * 1;
        $fileHint =  $plugin->config('hints.ProductFile.file');
        $this->useRecordSchema();
        $this->param('file','File')
            ->sizeLimit( $sizeLimit )  // Default to 10 MB limit
            ->label('檔案')
            ->hint( $fileHint )
            ->hintFromSizeLimit()
            ->putIn( 'static/upload' );
    }

    public function successMessage($ret)
    {
        return '檔案上傳成功。';
    }
}

