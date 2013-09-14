<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class ResourceSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'product_id',
  1 => 'url',
  2 => 'html',
  3 => 'id',
);
    public static $column_hash = array (
  'product_id' => 1,
  'url' => 1,
  'html' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'product_id',
  1 => 'url',
  2 => 'html',
  3 => 'id',
);

    const schema_class = 'ProductBundle\\Model\\ResourceSchema';
    const collection_class = 'ProductBundle\\Model\\ResourceCollection';
    const model_class = 'ProductBundle\\Model\\Resource';
    const model_name = 'Resource';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_resources';
    const label = 'Resource';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'product_id' => array( 
      'name' => 'product_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'refer' => 'ProductBundle\\Model\\Product',
          'label' => '產品',
        ),
    ),
  'url' => array( 
      'name' => 'url',
      'attributes' => array( 
          'type' => 'varchar(256)',
          'isa' => 'str',
          'size' => 256,
          'label' => '網址',
        ),
    ),
  'html' => array( 
      'name' => 'html',
      'attributes' => array( 
          'type' => 'varchar(512)',
          'isa' => 'str',
          'size' => 512,
          'label' => '內嵌 HTML',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
            ),
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
  'url',
  'html',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_resources';
        $this->modelClass      = 'ProductBundle\\Model\\Resource';
        $this->collectionClass = 'ProductBundle\\Model\\ResourceCollection';
        $this->label           = 'Resource';
        $this->relations       = array( 
  'product' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ResourceSchema',
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
