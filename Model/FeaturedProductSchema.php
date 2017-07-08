<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

use CommonBundle\Model\Mixin\MetaSchema;
use I18N\Model\Mixin\I18NSchema;

class FeaturedProductSchema extends DeclareSchema
{
    public function schema()
    {
        $this->column('title')
            ->varchar(128)
            ->label('主打商品標題');

        $this->column('subtitle')
            ->varchar(128)
            ->label('主打商品副標題')
            ;

        $this->column('description')
            ->text()
            ->label('主打商品敘述')
            ->renderAs('TextareaInput')
            ;

        $this->column('cover_image')
            ->varchar(128)
            ->label('封面圖')
            ->contentType('ImageFile') // Creates ImageParam
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config('upload_dir')) ? $c : 'upload';
                $param->size($bundle->config("FeaturedProduct.{$param->name}.size"))
                    ->sizeLimit($bundle->config("FeaturedProduct.{$param->name}.size"))
                    ->resizeWidth($bundle->config("FeaturedProduct.{$param->name}.resize_width") ?: 0)
                    ->putIn($uploadDir)
                    ->hint($bundle->config('FeaturedProduct.cover_image.hint'))
                    ->renderAs('ThumbImageFileInput')
                    ;
            })
            ;

        $this->mixin(I18NSchema::class);
        $this->mixin(MetaSchema::class);
    }
}



