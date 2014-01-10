<?php
namespace ProductBundle\Action;
use ActionKit;
use Phifty\FileUtils;
use ActionKit\RecordAction\CreateRecordAction;

class CreateProductImage extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductImage';

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = kernel()->bundle('ProductBundle');

        $imageSize = $bundle->config('images.image.size');
        $thumbSize = $bundle->config('images.thumb.size');
        $largeSize = $bundle->config('images.large.size');

        $imageSizeLimit = $bundle->config('images.image.size_limit');
        $thumbSizeLimit = $bundle->config('images.thumb.size_limit');
        $largeSizeLimit = $bundle->config('images.large.size_limit');

        $imageResizeWidth = $bundle->config('images.image.resize_width') ?: 0;
        $thumbResizeWidth = $bundle->config('images.thumb.resize_width') ?: 0;
        $largeResizeWidth = $bundle->config('images.large.resize_width') ?: 0;

        $uploadDir = $bundle->config('upload_dir') ?: 'upload';

        if( $bundle->config('zoom_image') ) {
            $this->param('large','Image')
                ->size($largeSize)
                ->label('最大圖')
                ->hint( $bundle->config('hints.ProductImage.large') )
                ->hintFromSizeInfo()
                ;
        }

        $this->param('image','Image')
            ->sizeLimit( $imageSizeLimit )
            ->size( $imageSize )
            ->sourceField( 'large' )
            ->required()
            ->hint( $bundle->config('hints.ProductImage.image') )
            ->hintFromSizeInfo()
            ->label('主圖')
            ;

        $this->param( 'thumb' , 'Image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->sourceField( 'image' )
            ->label('縮圖')
            ->hint( $bundle->config('hints.ProductImage.thumb') )
            ->hintFromSizeInfo()
            ;

    }


    public function successMessage($ret) 
    {
        return '產品圖新增成功';
    }
}



