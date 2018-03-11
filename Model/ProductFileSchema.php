<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;
use ProductBundle\Model\Product;
use CommonBundle\Model\Mixin\OrderingSchema;
use CommonBundle\Model\Mixin\MetaSchema;

class ProductFileSchema extends DeclareSchema
{
    public function getLabel()
    {
        return '產品檔案';
    }

    public function schema()
    {
        $bundle = kernel()->bundle('ProductBundle');

        $this->column('product_id')
            ->integer()
            ->refer(Product::class)
            ->renderAs('SelectInput')
            ->label('產品');

        $this->column('title')
            ->varchar(130)
            ->required(true)
            ->label('檔案標題');

        $this->column('mimetype')
            ->varchar(16)
            ->label('檔案格式')
            ->renderable(false)
            ;

        // FIXME: required is not working for file: ->required()
        $this->column('file')
            ->varchar(130)
            ->label('檔案')
            ->contentType('File')
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config("upload_dir")) ? $c : "upload";
                $param->loadConfig($bundle->config("ProductFile.{$param->name}"))
                    ->putIn($uploadDir)
                    ->renderAs("FileInput")
                    ;
            })
            ;

        $this->column('remark')
            ->text()
            ->label('備註')
            ->renderAs('TextareaInput')
            ;

        $this->mixin(MetaSchema::class);
        $this->mixin(OrderingSchema::class);
    }
}
