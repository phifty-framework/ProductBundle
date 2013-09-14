<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class ProductTypeSchema extends SchemaDeclare
{
    /* ProductType is like, Product Attribute 
     *
     * One Product can have blue, red, gray colors.
     **/
    public function schema()
    {
        $this->column('product_id')
            ->integer()
            ->label('產品')
            ->renderAs('SelectInput')
            ->refer('ProductBundle\\Model\\Product');

        $this->column('name')
            ->varchar(120)
            ->required()
            ->label('名稱');

        $this->column('description')
            ->varchar(256)
            ->label('敘述')
            ;
        $this->column('spec')
            ->type('text')
            ->label('規格');
    }

    function dataLabel() {
        return $this->name;
    }


}
