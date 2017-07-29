<?php
namespace ProductBundle\Action;

use WebAction\RecordAction\UpdateRecordAction;
use ProductBundle\Model\ProductFile;

class UpdateProductFile extends UpdateRecordAction
{
    public $recordClass = ProductFile::class;

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $this->useRecordSchema();
        $this->replaceParam('file', 'File')
            ->sizeLimit($bundle->config('file.size_limit') ?: 1024 * 10)  // Default to 10 MB limit
            ->label('檔案')
            ->putIn('upload');
    }
}
