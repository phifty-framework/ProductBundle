<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\BulkZhConvertRecordAction;

class BulkZhConvertProduct extends BulkZhConvertRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
    public $convertionKeys = array('name','subtitle','content','description','spec');
}

