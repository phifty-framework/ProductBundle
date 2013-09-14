<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class CategoryFileSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'category_id',
  1 => 'title',
  2 => 'mimetype',
  3 => 'file',
  4 => 'id',
);
    public static $column_hash = array (
  'category_id' => 1,
  'title' => 1,
  'mimetype' => 1,
  'file' => 1,
  'id' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'category_id',
  1 => 'title',
  2 => 'mimetype',
  3 => 'file',
  4 => 'id',
);

    const schema_class = 'LazyRecord\\Schema\\DynamicSchemaDeclare';
    const collection_class = 'ProductBundle\\Model\\CategoryFileCollection';
    const model_class = 'ProductBundle\\Model\\CategoryFile';
    const model_name = 'CategoryFile';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'category_files';
    const label = 'CategoryFile';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'category_id' => array( 
      'name' => 'category_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'refer' => 'ProductBundle\\Model\\Category',
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '類別',
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
  'category_id',
  'title',
  'mimetype',
  'file',
);
        $this->primaryKey      = 'id';
        $this->table           = 'category_files';
        $this->modelClass      = 'ProductBundle\\Model\\CategoryFile';
        $this->collectionClass = 'ProductBundle\\Model\\CategoryFileCollection';
        $this->label           = 'CategoryFile';
        $this->relations       = array( 
  'category' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'LazyRecord\\Schema\\DynamicSchemaDeclare',
      'self_column' => 'category_id',
      'foreign_schema' => 'ProductBundle\\Model\\Category',
      'foreign_column' => 'id',
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

}
