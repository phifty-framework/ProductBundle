<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class ProductTagSchema extends SchemaDeclare
{
    public function schema() {
        $this->table('product_tag_junction');

        $this->column( 'product_id' )
            ->integer()
            ->refer('ProductBundle\\Model\\Product')
            ->renderAs('SelectInput')
            ->label('產品');

        $this->column('tag_id')
            ->integer();

        $this->belongsTo('product' , 'ProductBundle\\Model\\ProductSchema','id','product_id');
        $this->belongsTo('tag' , 'ProductBundle\\Model\\TagSchema','id','tag_id');
    }
}
