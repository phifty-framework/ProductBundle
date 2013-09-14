<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class ProductTypeSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'product_id',
  1 => 'name',
  2 => 'description',
  3 => 'spec',
  4 => 'id',
);
    public static $column_hash = array (
  'product_id' => 1,
  'name' => 1,
  'description' => 1,
  'spec' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'product_id',
  1 => 'name',
  2 => 'description',
  3 => 'spec',
  4 => 'id',
);

    const schema_class = 'ProductBundle\\Model\\ProductTypeSchema';
    const collection_class = 'ProductBundle\\Model\\ProductTypeCollection';
    const model_class = 'ProductBundle\\Model\\ProductType';
    const model_name = 'ProductType';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_types';
    const label = 'ProductType';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'product_id' => array( 
      'name' => 'product_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'label' => '產品',
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'refer' => 'ProductBundle\\Model\\Product',
        ),
    ),
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(120)',
          'isa' => 'str',
          'size' => 120,
          'required' => true,
          'label' => '名稱',
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'type' => 'varchar(256)',
          'isa' => 'str',
          'size' => 256,
          'label' => '敘述',
        ),
    ),
  'spec' => array( 
      'name' => 'spec',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '規格',
        ),
    ),
  'id' => array( 
      'name' => 'id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'primary' => true,
          'autoIncrement' => true,
        ),
    ),
);
        $this->columnNames     = array( 
  'id',
  'product_id',
  'name',
  'description',
  'spec',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_types';
        $this->modelClass      = 'ProductBundle\\Model\\ProductType';
        $this->collectionClass = 'ProductBundle\\Model\\ProductTypeCollection';
        $this->label           = 'ProductType';
        $this->relations       = array( 
  'product' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ProductTypeSchema',
      'self_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\Product',
      'foreign_column' => 'id',
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

}
