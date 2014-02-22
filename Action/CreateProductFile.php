<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;

class CreateProductFile extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductFile';

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $sizeLimit = $bundle->config('ProductFile.size_limit') ?: 1024 * 10;
        $fileHint =  $bundle->config('ProductFile.hint');
        $this->useRecordSchema();
        $this->param('file','File')
            ->sizeLimit( $sizeLimit )  // Default to 10 MB limit
            ->label('檔案')
            ->hint( $fileHint )
            ->hintFromSizeLimit()
            ->putIn( 'upload' );
    }

    public function successMessage($ret)
    {
        return '檔案上傳成功。';
    }
}

