<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\CreateRecordAction;

class CreateCategoryFile extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\CategoryFile';

    public function schema()
    {
        $plugin = \ProductBundle\ProductBundle::getInstance();
        $sizeLimit = $plugin->config('category_files.size_limit') ?: 1024 * 10;
        $fileHint =  $plugin->config('hints.CategoryFile.file');
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

