<?php
namespace ProductBundle\Action;

use WebAction\RecordAction\BulkZhConvertRecordAction;

class BulkZhConvertProduct extends BulkZhConvertRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
    public $convertionKeys = array('name','subtitle','content','description','spec');
}
