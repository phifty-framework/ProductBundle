<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

class ProductTagSchema extends DeclareSchema
{
    public function schema()
    {
        $this->table('product_tag_junction');

        $this->column('product_id')
            ->unsigned()
            ->integer()
            ->required()
            ->refer(Product::class)
            ->renderAs('SelectInput')
            ->label('產品');

        $this->column('tag_id')
            ->integer()
            ->required()
            ->unsigned()
            ;

        $this->belongsTo('product', ProductSchema::class, 'id', 'product_id');
        $this->belongsTo('tag', TagSchema::class, 'id', 'tag_id');
    }
}
