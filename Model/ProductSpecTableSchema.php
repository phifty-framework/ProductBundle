<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;

class ProductSpecTableSchema extends DeclareSchema
{
    public function schema() {
        $this->label('Specification Table');
        $this->table('product_spec_tables');

        $this->column( 'product_id' )
            ->integer()
            ->refer('ProductBundle\\Model\\Product')
            ->renderAs('SelectInput')
            ->label('產品');

        $this->mixin('CommonBundle\\Model\\Mixin\\OrderingSchema');
        $this->mixin('TableBundle\\Model\\Mixin\\TableMixinSchema');
    }
}
