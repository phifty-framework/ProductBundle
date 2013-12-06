<?php
namespace ProductBundle\Action;

class ProductBaseMixin
{
    public $bundle;

    /**
     * The object to mixin
     */
    public $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function preinit()
    {
        $this->object->nested = true;
    }

    public function schema()
    {
        $this->object->useRecordSchema();

        $this->bundle = kernel()->bundle('ProductBundle');

        $imageSize     = $this->bundle->config('cover.image.size');
        $thumbSize     = $this->bundle->config('cover.thumb.size');
        $zoomImageSize = $this->bundle->config('cover.zoom_image.size');

        $specImageSize     = $this->bundle->config('spec.image.size');
        $specThumbSize     = $this->bundle->config('spec.thumb.size');

        $imageSizeLimit     = $this->bundle->config('cover.image.size_limit');
        $thumbSizeLimit     = $this->bundle->config('cover.thumb.size_limit');
        $zoomImageSizeLimit = $this->bundle->config('cover.zoom_image.size_limit');

        $imageResizeWidth     = $this->bundle->config('cover.image.resize_width') ?: 0;
        $thumbResizeWidth     = $this->bundle->config('cover.thumb.resize_width') ?: 0;
        $zoomImageResizeWidth = $this->bundle->config('cover.zoom_image.resize_width') ?: 0;
        $uploadDir            = $this->bundle->config('upload_dir') ?: 'static/upload';
        $autoResize           = $this->bundle->config('autoresize') ?: false;

        if( $this->bundle->config('with_zoom_image') ) {
            $this->object->param('zoom_image','Image')
                ->size( $zoomImageSize )
                ->sizeLimit( $zoomImageSizeLimit )
                ->resizeWidth( $zoomImageResizeWidth )
                ->label('產品放大圖')
                ->autoResize($autoResize)
                ->hint( $this->bundle->config('hints.Product.zoom_image') )
                ->hintFromSizeInfo()
                ;
        }

        if( $this->bundle->config('with_spec_image') ) {

            $this->object->param('spec_image','Image')
                ->size( $specImageSize )
                ->sizeLimit( $imageSizeLimit )
                ->autoResize($autoResize)
                ->label( '規格圖' )
                ->hint( $this->bundle->config('hints.Product.spec_image') )
                ->hintFromSizeInfo()
                ;

            $this->object->param( 'spec_thumb' , 'Image' )
                ->sourceField( 'spec_image' )
                ->size( $specThumbSize )
                ->sizeLimit($thumbSizeLimit)
                ->autoResize($autoResize)
                ->label( '規格縮圖' )
                ->hint( $this->bundle->config('hints.Product.spec_thumb') )
                ->hintFromSizeInfo()
                ;
        }

        $this->object->param('image','Image')
            ->sourceField( 'zoom_image' )
            ->size( $imageSize )
            ->sizeLimit( $imageSizeLimit )
            ->autoResize($autoResize)
            ->hint( $this->bundle->config('hints.Product.image') )
            ->hintFromSizeInfo()
            ;

        $this->object->param( 'thumb' , 'Image' )
            ->sourceField( 'image' )
            ->size( $thumbSize )
            ->sizeLimit( $thumbSizeLimit )
            ->autoResize($autoResize)
            ->hint( $this->bundle->config('hints.Product.thumb') )
            ->hintFromSizeInfo()
            ;

    }
}



