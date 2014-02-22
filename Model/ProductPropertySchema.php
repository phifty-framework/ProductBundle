<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class ProductPropertySchema extends SchemaDeclare
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
