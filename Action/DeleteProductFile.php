<?php
namespace ProductBundle\Action;

use WebAction\RecordAction\DeleteRecordAction;

class DeleteProductFile extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductFile';

    public function run()
    {
        if (file_exists($this->record->file)) {
            unlink($this->record->file);
        }
        return parent::run();
    }
}
