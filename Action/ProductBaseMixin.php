<?php
namespace ProductBundle\Action;
use ActionKit\MixinAction;

class ProductBaseMixin extends MixinAction
{
    public function preinit()
    {
        $this->nested = true;
    }

    public function schema()
    {
        $this->useRecordSchema();

        $bundle = kernel()->bundle('ProductBundle');

        $imageSize     = $bundle->config('Product.image.size');
        $imageSizeLimit     = $bundle->config('Product.image.size_limit');
        $imageResizeWidth     = $bundle->config('Product.image.resize_width') ?: 0;

        $thumbSize     = $bundle->config('Product.thumb.size');
        $thumbSizeLimit     = $bundle->config('Product.thumb.size_limit');
        $thumbResizeWidth     = $bundle->config('Product.thumb.resize_width') ?: 0;

        $coverImageSize     = $bundle->config('Product.cover_image.size');
        $coverImageSizeLimit   = $bundle->config('Product.cover_image.size_limit') ?: 0;
        $coverImageResizeWidth = $bundle->config('Product.cover_image.resize_width') ?: 0;


        $zoomImageSize = $bundle->config('Product.zoom_image.size');
        $zoomImageSizeLimit = $bundle->config('Product.zoom_image.size_limit');
        $zoomImageResizeWidth = $bundle->config('Product.zoom_image.resize_width') ?: 0;

        $specImageSize     = $bundle->config('Product.spec_image.size');
        $specThumbSize     = $bundle->config('Product.spec_thumb.size');

        $uploadDir            = $bundle->config('upload_dir') ?: 'upload';
        $autoResize           = $bundle->config('auto_resize') ?: false;

        if( $bundle->config('Product.zoom_image') ) {
            $this->param('zoom_image','Image')
                ->size( $zoomImageSize )
                ->sizeLimit( $zoomImageSizeLimit )
                ->resizeWidth( $zoomImageResizeWidth )
                ->label('產品放大圖')
                ->autoResize($autoResize)
                ->hint( $bundle->config('Product.zoom_image.hint') )
                ->hintFromSizeInfo()
                ;
        }

        if( $bundle->config('Product.cover_image') ) {
            $this->param('cover_image','Image')
                ->size($coverImageSize)
                ->resizeWidth( $coverImageResizeWidth )
                ->label('首頁圖')
                ->autoResize($autoResize)
                ->hint( $bundle->config('Product.cover_image.hint') )
                ->hintFromSizeInfo()
                ;
        }

        if( $bundle->config('Product.spec_content_image') ) {

            $this->param('spec_image','Image')
                ->size( $specImageSize )
                ->sizeLimit( $imageSizeLimit )
                ->autoResize($autoResize)
                ->label( '規格圖' )
                ->hint( $bundle->config('Product.spec_image.hint') )
                ->hintFromSizeInfo()
                ;

            $this->param( 'spec_thumb' , 'Image' )
                ->sourceField( 'spec_image' )
                ->size( $specThumbSize )
                ->sizeLimit($thumbSizeLimit)
                ->autoResize($autoResize)
                ->label( '規格縮圖' )
                ->hint( $bundle->config('Product.spec_thumb.hint') )
                ->hintFromSizeInfo()
                ;
        }

        $this->param('image','Image')
            ->sourceField( 'zoom_image' )
            ->size( $imageSize )
            ->sizeLimit( $imageSizeLimit )
            ->autoResize($autoResize)
            ->resizeWidth( $imageResizeWidth )
            ->hint( $bundle->config('Product.image.hint') )
            ->hintFromSizeInfo()
            ;

        $this->param( 'thumb' , 'Image' )
            ->sourceField( 'image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->autoResize($autoResize)
            ->resizeWidth( $thumbResizeWidth )
            ->hint( $bundle->config('Product.thumb.hint') )
            ->hintFromSizeInfo()
            ;

    }
}



