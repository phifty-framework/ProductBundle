<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\BulkCopyRecordAction;

class BulkCopyProduct extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
    public $newFields = array('lang', 'category_id');
}

