<?php
namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

class ProductProductSchema extends DeclareSchema
{
    public function schema() {
        $this->column('product_id')
            ->integer()
            ->refer('ProductBundle\\Model\\Product')
            ->renderAs('SelectInput')
            ->label('產品')
            ;
        $this->column('related_product_id')
            ->integer()
            ->refer('ProductBundle\\Model\\Product')
            ->renderAs('SelectInput')
            ->label('關連產品')
            ;

        $this->mixin('SortablePlugin\\Model\\Mixin\\OrderingSchema');

        $this->belongsTo('product','ProductBundle\\Model\\ProductSchema','id','product_id');
        $this->belongsTo('related_product','ProductBundle\\Model\\ProductSchema','id','related_product_id');
    }
}


