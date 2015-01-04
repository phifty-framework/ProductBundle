<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class TagSchema extends SchemaDeclare
{
    public function schema() 
    {
        $this->column('name')
            ->varchar(60)
            ->unique()
            ->required()
            ;

        $this->many('tag_products', 'ProductBundle\\Model\\ProductTagSchema', 'tag_id', 'id' );
        $this->manyToMany('products', 'tag_products' , 'product');
    }
}
