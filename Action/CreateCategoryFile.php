<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;

class CreateCategoryFile extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\CategoryFile';

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $sizeLimit = $bundle->config('CategoryFile.size_limit') ?: 1024 * 10;
        $fileHint =  $bundle->config('CategoryFile.hint');
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

