<?php
namespace ProductBundle\Action;
use ActionKit;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteProductImage extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductImage';

    public function run()
    {
        /*
        TODO: get action file param columns and delete these files (in absolute path)
        if( file_exists($this->record->thumb ))
            unlink( PH_APP_ROOT . '/webroot/' . $this->record->thumb );
        if( file_exists($this->record->image ))
            unlink( PH_APP_ROOT . '/webroot/' . $this->record->image );
        */
        return parent::run();
    }

    public function successMessage($ret)
    {
        return '產品圖片刪除成功。';
    }
}


