<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteCategoryFile extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\CategoryFile';

    public function run()
    {
        if( file_exists($this->record->file) )
            unlink($this->record->file);
        return parent::run();
    }
}

