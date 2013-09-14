<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\BulkCopyRecordAction;

class BulkCopyCategory extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Category';
    public $newFields = array('lang');
}

