<?php
namespace ProductBundle\Action;

use WebAction;
use WebAction\RecordAction\DeleteRecordAction;

class DeleteProduct extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
}
