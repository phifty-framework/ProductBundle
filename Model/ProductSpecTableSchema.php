<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class ProductSpecTableSchema extends SchemaDeclare
{
    public function schema() {
        $this->label('Specification Table');
        $this->table('product_spec_tables');

        $this->column( 'product_id' )
            ->integer()
            ->refer('ProductBundle\\Model\\Product')
            ->renderAs('SelectInput')
            ->label('產品');

        $this->mixin('SortablePlugin\\Model\\Mixin\\OrderingSchema');
        $this->mixin('TableBundle\\Model\\Mixin\\TableMixinSchema');
    }
}
