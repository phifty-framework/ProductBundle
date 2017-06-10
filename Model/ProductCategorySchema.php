<?php

namespace ProductBundle\Model;

use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;
use Maghead\Schema\DeclareSchema;

class ProductCategorySchema extends DeclareSchema
{
    public function schema()
    {
        $this->table('product_category_junction');

        $this->column('product_id')
            ->unsigned()
            ->integer()
            ->required()
            ;

        $this->column('category_id')
            ->unsigned()
            ->integer()
            ->required()
            ;

        $this->belongsTo('category', CategorySchema::class, 'id', 'category_id');
        $this->belongsTo('product', ProductSchema::class, 'id', 'product_id');
    }
}
