<?php

namespace ProductBundle\Action;

use ActionKit;
use Phifty\FileUtils;

class CreateProductImage extends \ActionKit\RecordAction\CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductImage';

    public function schema()
    {
        $this->useRecordSchema();
        $plugin = kernel()->plugin('ProductBundle');

        $imageSize = $plugin->config('images.image.size');
        $thumbSize = $plugin->config('images.thumb.size');
        $largeSize = $plugin->config('images.large.size');

        $imageSizeLimit = $plugin->config('images.image.size_limit');
        $thumbSizeLimit = $plugin->config('images.thumb.size_limit');
        $largeSizeLimit = $plugin->config('images.large.size_limit');

        $imageResizeWidth = $plugin->config('images.image.resize_width') ?: 0;
        $thumbResizeWidth = $plugin->config('images.thumb.resize_width') ?: 0;
        $largeResizeWidth = $plugin->config('images.large.resize_width') ?: 0;

        $uploadDir = $plugin->config('upload_dir') ?: 'static/upload';

        if( $plugin->config('with_zoom_image') ) {
            $this->param('large','Image')
                ->size($largeSize)
                ->label('最大圖')
                ->hint( $plugin->config('hints.ProductImage.large') )
                ->hintFromSizeInfo()
                ;
        }

        $this->param('image','Image')
            ->sizeLimit( $imageSizeLimit )
            ->size( $imageSize )
            ->sourceField( 'large' )
            ->required()
            ->hint( $plugin->config('hints.ProductImage.image') )
            ->hintFromSizeInfo()
            ->label('主圖')
            ;

        $this->param( 'thumb' , 'Image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->sourceField( 'image' )
            ->label('縮圖')
            ->hint( $plugin->config('hints.ProductImage.thumb') )
            ->hintFromSizeInfo()
            ;

    }


    public function successMessage($ret) 
    {
        return '產品圖新增成功';
    }
}



