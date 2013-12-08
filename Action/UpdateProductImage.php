<?php
namespace ProductBundle\Action;

use ActionKit;
use Phifty\FileUtils;

class UpdateProductImage extends \ActionKit\RecordAction\UpdateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductImage';

    public function schema() 
    {
        $this->useRecordSchema();
        $bundle = kernel()->bundle('ProductBundle');

        $this->param('image','Image')
            ->sizeLimit( ($c = $bundle->config('images.image.size_limit')) ? $c : 800 )
            ->required()
            ->label('主圖')
            ->putIn( 'upload' );

        $this->param( 'thumb' , 'Image' )
            ->sizeLimit( ($c = $bundle->config('images.thumb.size_limit')) ? $c : 500 )
            ->resizeWidth( $c = $bundle->config('images.thumb.resize_width') )
            ->sourceField( 'image' )
            ->label('縮圖')
            ->putIn( 'upload' );

        $this->param('large','Image')
            ->sourceField( 'image' )
            ->label('最大圖')
            ->putIn( 'upload' );
            ;
    }

    public function successMessage($ret) 
    {
        return '產品圖片資料更新成功。';
    }
}

