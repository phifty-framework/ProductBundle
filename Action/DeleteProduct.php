<?php
namespace ProductBundle\Action;
use ActionKit;
use ActionKit\RecordAction\DeleteRecordAction;

class DeleteProduct extends DeleteRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';

    public function run()
    {
        foreach( $this->record->images as $image ) {
            @$image->delete();
        }

        foreach( $this->record->types as $type ) {
            @$type->delete();
        }

        foreach( $this->record->resources as $res ) {
            @$res->delete();
        }

        foreach( $this->record->product_features as $pf ) {
            @$pf->delete();
        }

        /*
        if( file_exists($this->record->thumb) )
            unlink( PH_APP_ROOT . '/webroot/' . $this->record->thumb );
        if( file_exists($this->record->image ) )
            unlink( PH_APP_ROOT . '/webroot/' . $this->record->image );
        */
        return parent::run();
    }
}
