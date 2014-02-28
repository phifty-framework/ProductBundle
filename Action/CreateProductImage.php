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

        $imageSize = $bundle->config('ProductImage.image.size');
        $thumbSize = $bundle->config('ProductImage.thumb.size');
        $largeSize = $bundle->config('ProductImage.large.size');

        $imageSizeLimit = $bundle->config('ProductImage.image.size_limit');
        $thumbSizeLimit = $bundle->config('ProductImage.thumb.size_limit');
        $largeSizeLimit = $bundle->config('ProductImage.large.size_limit');

        $imageResizeWidth = $bundle->config('ProductImage.image.resize_width') ?: 0;
        $thumbResizeWidth = $bundle->config('ProductImage.thumb.resize_width') ?: 0;
        $largeResizeWidth = $bundle->config('ProductImage.large.resize_width') ?: 0;

        $uploadDir = $bundle->config('upload_dir') ?: 'upload';

        if( $bundle->config('ProductImage.large') ) {
            $this->param('large','Image')
                ->size($largeSize)
                ->label('最大圖')
                ->hint( $bundle->config('ProductImage.large.hint') )
                ->hintFromSizeInfo()
                ;
        }

        $this->param('image','Image')
            ->sizeLimit( $imageSizeLimit )
            ->size( $imageSize )
            ->sourceField( 'large' )
            ->required()
            ->hint( $bundle->config('ProductImage.image.hint') )
            ->hintFromSizeInfo()
            ->label('主圖')
            ;

        $this->param( 'thumb' , 'Image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->sourceField( 'image' )
            ->label('縮圖')
            ->hint( $bundle->config('ProductImage.thumb.hint') )
            ->hintFromSizeInfo()
            ;

    }


    public function successMessage($ret) 
    {
        return '產品圖新增成功';
    }
}



