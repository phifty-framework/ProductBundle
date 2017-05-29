<?php
namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

if ( $bundle = kernel()->bundle('UseCaseBundle') ) {

class ProductUseCaseSchema extends DeclareSchema
{
    public function schema()
    {
        $this->column('product_id')
            ->integer()
            ->refer('ProductBundle\\Model\\ProductSchema')
            ->renderAs('SelectInput')
            ->label('產品')
            ;
        $this->column('usecase_id')
            ->integer()
            ->refer('UseCaseBundle\\Model\\UseCaseSchema')
            ->renderAs('SelectInput')
            ->label('關連案例')
            ;
        $this->mixin('SortablePlugin\\Model\\Mixin\\OrderingSchema');
        $this->belongsTo('product','ProductBundle\\Model\\ProductSchema','id','product_id');
        $this->belongsTo('usecase','UseCaseBundle\\Model\\UseCaseSchema','id','usecase_id');
    }
}

}
