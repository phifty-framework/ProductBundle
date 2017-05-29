<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;

class ProductPropertySchema extends DeclareSchema
{
    public function schema() 
    {
        $this->column('name')->varchar(64);
        $this->column('value')->varchar(512);
        $this->column('product_id')
            ->integer()
            ->refer( 'ProductBundle\\Model\\ProductSchema')
            ;
        $this->mixin('SortablePlugin\\Model\\Mixin\\OrderingSchema');
        $this->belongsTo('product','ProductBundle\\Model\\ProductSchema','id','product_id');
    }
}
