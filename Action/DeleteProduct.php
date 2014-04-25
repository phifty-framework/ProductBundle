<?php
namespace ProductBundle\Action;
use ActionKit;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteProduct extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
}
