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

        $imageSize     = $bundle->config('image.size');
        $thumbSize     = $bundle->config('thumb.size');
        $zoomImageSize = $bundle->config('zoom_image.size');

        $coverImageSize     = $bundle->config('cover_image.size');
        $coverImageResizeWidth     = $bundle->config('cover_image.resize_width') ?: 0;

        $specImageSize     = $bundle->config('spec.image.size');
        $specThumbSize     = $bundle->config('spec.thumb.size');

        $imageSizeLimit     = $bundle->config('image.size_limit');
        $thumbSizeLimit     = $bundle->config('thumb.size_limit');
        $zoomImageSizeLimit = $bundle->config('zoom_image.size_limit');

        $imageResizeWidth     = $bundle->config('image.resize_width') ?: 0;
        $thumbResizeWidth     = $bundle->config('thumb.resize_width') ?: 0;
        $zoomImageResizeWidth = $bundle->config('zoom_image.resize_width') ?: 0;
        $uploadDir            = $bundle->config('upload_dir') ?: 'upload';
        $autoResize           = $bundle->config('auto_resize') ?: false;

        if( $bundle->config('zoom_image') ) {
            $this->param('zoom_image','Image')
                ->size( $zoomImageSize )
                ->sizeLimit( $zoomImageSizeLimit )
                ->resizeWidth( $zoomImageResizeWidth )
                ->label('產品放大圖')
                ->autoResize($autoResize)
                ->hint( $bundle->config('hints.Product.zoom_image') )
                ->hintFromSizeInfo()
                ;
        }

        if( $bundle->config('cover_image') ) {
            $this->param('cover_image','Image')
                ->size($coverImageSize)
                ->resizeWidth( $coverImageResizeWidth )
                ->label('首頁圖')
                ->autoResize($autoResize)
                ->hint( $bundle->config('hints.Product.cover_image') )
                ->hintFromSizeInfo()
                ;
        }

        if( $bundle->config('spec_content_image') ) {

            $this->param('spec_image','Image')
                ->size( $specImageSize )
                ->sizeLimit( $imageSizeLimit )
                ->autoResize($autoResize)
                ->label( '規格圖' )
                ->hint( $bundle->config('hints.Product.spec_image') )
                ->hintFromSizeInfo()
                ;

            $this->param( 'spec_thumb' , 'Image' )
                ->sourceField( 'spec_image' )
                ->size( $specThumbSize )
                ->sizeLimit($thumbSizeLimit)
                ->autoResize($autoResize)
                ->label( '規格縮圖' )
                ->hint( $bundle->config('hints.Product.spec_thumb') )
                ->hintFromSizeInfo()
                ;
        }

        $this->param('image','Image')
            ->sourceField( 'zoom_image' )
            ->size( $imageSize )
            ->sizeLimit( $imageSizeLimit )
            ->autoResize($autoResize)
            ->resizeWidth( $imageResizeWidth )
            ->hint( $bundle->config('hints.Product.image') )
            ->hintFromSizeInfo()
            ;

        $this->param( 'thumb' , 'Image' )
            ->sourceField( 'image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->autoResize($autoResize)
            ->resizeWidth( $thumbResizeWidth )
            ->hint( $bundle->config('hints.Product.thumb') )
            ->hintFromSizeInfo()
            ;

    }
}



