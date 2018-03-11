<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;
use ProductBundle\Model\Product;
use CommonBundle\Model\Mixin\OrderingSchema;

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
            ->label('檔案標題');

        $this->column('mimetype')
            ->varchar(16)
            ->label('檔案格式')
            ->renderable(false)
            ;

        $this->column('file')
            ->varchar(130)
            ->required()
            ->label('檔案')
            ->contentType('File')
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config("upload_dir")) ? $c : "upload";
                $param->putIn($uploadDir)->renderAs('FileInput');
            })
            ;

        $this->mixin(OrderingSchema::class);
    }
}
