<?php
namespace ProductBundle\Action;

use WebAction\RecordAction\BulkCopyRecordAction;

class BulkCopyProduct extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
    public $newFields = array('lang', 'category_id');
}
