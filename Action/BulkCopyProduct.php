<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\BulkCopyRecordAction;
use Phifty\FileUtils;

function duplicate_file($from) {
    $to = FileUtils::filename_increase($from);
    copy($from , $to);
    return $to;
}

function duplicate_record_files($source, $fields) {
    $output = $source;
    foreach( $fields as $field ) {
        if ( isset($output[$field]) ) {
            $output[$field] = duplicate_file($output[$field]);
        }
    }
    return $output;
}

class BulkCopyProduct extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';
    public $newFields = array('lang', 'category_id');
}

