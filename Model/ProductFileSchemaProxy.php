<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class ProductFileSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'product_id',
  1 => 'title',
  2 => 'mimetype',
  3 => 'file',
  4 => 'id',
);
    public static $column_hash = array (
  'product_id' => 1,
  'title' => 1,
  'mimetype' => 1,
  'file' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'product_id',
  1 => 'title',
  2 => 'mimetype',
  3 => 'file',
  4 => 'id',
);

    const schema_class = 'ProductBundle\\Model\\ProductFileSchema';
    const collection_class = 'ProductBundle\\Model\\ProductFileCollection';
    const model_class = 'ProductBundle\\Model\\ProductFile';
    const model_name = 'ProductFile';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_files';
    const label = '產品檔案';

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
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '產品',
        ),
    ),
  'title' => array( 
      'name' => 'title',
      'attributes' => array( 
          'type' => 'varchar(130)',
          'isa' => 'str',
          'size' => 130,
          'label' => '檔案標題',
        ),
    ),
  'mimetype' => array( 
      'name' => 'mimetype',
      'attributes' => array( 
          'type' => 'varchar(16)',
          'isa' => 'str',
          'size' => 16,
          'label' => '檔案格式',
        ),
    ),
  'file' => array( 
      'name' => 'file',
      'attributes' => array( 
          'type' => 'varchar(130)',
          'isa' => 'str',
          'size' => 130,
          'required' => true,
          'label' => '檔案',
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
  'title',
  'mimetype',
  'file',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_files';
        $this->modelClass      = 'ProductBundle\\Model\\ProductFile';
        $this->collectionClass = 'ProductBundle\\Model\\ProductFileCollection';
        $this->label           = '產品檔案';
        $this->relations       = array( 
  'product' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ProductFileSchema',
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
