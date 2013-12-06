<?php
namespace ProductBundle\Action;
use ActionKit;
use Phifty\FileUtils;
use ActionKit\RecordAction\CreateRecordAction;

class CreateCategory extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Category';
    public $nested = true;
    public $relationships = array(
        'files' => array(
            'has_many' => true,
            'record' => 'ProductBundle\\Model\\CategoryFile',
            'self_key' => 'category_id',
            'foreign_key' => 'id',
        ),
    );

    public function schema() 
    { 
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'static/upload';

        $this->param('image','Image')
            ->sizeLimit( ($c=$bundle->config('category_image.size_limit')) ? $c : 600 )
            ->resizeWidth( ($c = $bundle->config('category_image.resize_width') ) ?  $c : 800 )
            ->renameFile( function( $name ) {
                return FileUtils::filename_append_md5( $name );
            })
            ->putIn( $uploadDir );

        $this->param( 'thumb' , 'Image' )
            ->sizeLimit( ($c=$bundle->config('category_thumb.size_limit')) ? $c : 500 )
            ->resizeWidth( ($c = $bundle->config('category_thumb.resize_width') ) ? $c : 300 )
            ->sourceField( 'image' )
            ->renameFile( function( $name ) { 
                return FileUtils::filename_append_md5( $name );
            })
            ->putIn( 'static/upload' );
    }
}

