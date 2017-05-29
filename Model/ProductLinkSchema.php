<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;
use CommonBundle\Model\Mixin\OrderingSchema;

class ProductLinkSchema extends DeclareSchema
{
    public function schema() 
    {
        $this->column('label')->varchar(128);
        $this->column('url')->varchar(128);
        $this->column('product_id')
            ->integer()
            ->refer( 'ProductBundle\\Model\\ProductSchema')
            ;
        $this->mixin(OrderingSchema::class);
        $this->belongsTo('product','ProductBundle\\Model\\ProductSchema','id','product_id');
    }
}
