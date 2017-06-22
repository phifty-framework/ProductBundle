<?php
namespace ProductBundle\Action;

use WebAction\RecordAction\BulkCopyRecordAction;

class BulkCopyCategory extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Category';
    public $newFields = array('lang');
}
