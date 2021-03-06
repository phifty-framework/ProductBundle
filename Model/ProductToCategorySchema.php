<?php

namespace ProductBundle\Model;

use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;
use Maghead\Schema\DeclareSchema;

class ProductToCategorySchema extends DeclareSchema
{
    public function schema()
    {
        $this->table('product_to_categories');

        $this->column('product_id')
            ->integer()
            ->unsigned()
            ->required()
            ;

        $this->column('category_id')
            ->integer()
            ->unsigned()
            ->required()
            ;

        $this->belongsTo('category', CategorySchema::class, 'id', 'category_id');
        $this->belongsTo('product', ProductSchema::class, 'id', 'product_id');
    }
}
