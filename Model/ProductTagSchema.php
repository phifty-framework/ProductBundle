<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;

class ProductTagSchema extends DeclareSchema
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
