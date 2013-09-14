<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class FeatureSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'name',
  1 => 'description',
  2 => 'image',
  3 => 'lang',
  4 => 'id',
);
    public static $column_hash = array (
  'name' => 1,
  'description' => 1,
  'image' => 1,
  'lang' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
  0 => 'I18N\\Model\\Mixin\\I18NSchema',
);
    public static $column_names_include_virtual = array (
  0 => 'name',
  1 => 'description',
  2 => 'image',
  3 => 'lang',
  4 => 'id',
);

    const schema_class = 'ProductBundle\\Model\\FeatureSchema';
    const collection_class = 'ProductBundle\\Model\\FeatureCollection';
    const model_class = 'ProductBundle\\Model\\Feature';
    const model_name = 'Feature';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_features';
    const label = 'Feature';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '產品功能名稱',
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '敘述',
        ),
    ),
  'image' => array( 
      'name' => 'image',
      'attributes' => array( 
          'type' => 'varchar(250)',
          'isa' => 'str',
          'size' => 250,
          'label' => '產品功能圖',
        ),
    ),
  'lang' => array( 
      'name' => 'lang',
      'attributes' => array( 
          'type' => 'varchar(12)',
          'isa' => 'str',
          'size' => 12,
          'validValues' => function() {
                return array_flip( kernel()->locale->available() );
            },
          'label' => '語言',
          'default' => function() {
                return kernel()->locale->getDefault();
            },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
              'allow_empty' => true,
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
  'name',
  'description',
  'image',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_features';
        $this->modelClass      = 'ProductBundle\\Model\\Feature';
        $this->collectionClass = 'ProductBundle\\Model\\FeatureCollection';
        $this->label           = 'Feature';
        $this->relations       = array( 
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

}
