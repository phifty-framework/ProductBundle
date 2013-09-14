<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class ProductImageSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'product_id',
  1 => 'title',
  2 => 'large',
  3 => 'thumb',
  4 => 'image',
  5 => 'id',
  6 => 'ordering',
);
    public static $column_hash = array (
  'product_id' => 1,
  'title' => 1,
  'large' => 1,
  'thumb' => 1,
  'image' => 1,
  'id' => 1,
  'ordering' => 1,
);
    public static $mixin_classes = array (
  0 => 'SortableBundle\\Model\\Mixin\\OrderingSchema',
  1 => 'CommonBundle\\Model\\Mixin\\ImageSchema',
);
    public static $column_names_include_virtual = array (
  0 => 'product_id',
  1 => 'title',
  2 => 'large',
  3 => 'thumb',
  4 => 'image',
  5 => 'id',
  6 => 'ordering',
);

    const schema_class = 'ProductBundle\\Model\\ProductImageSchema';
    const collection_class = 'ProductBundle\\Model\\ProductImageCollection';
    const model_class = 'ProductBundle\\Model\\ProductImage';
    const model_name = 'ProductImage';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_images';
    const label = '產品圖';

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
          'label' => '圖片標題',
        ),
    ),
  'large' => array( 
      'name' => 'large',
      'attributes' => array( 
          'type' => 'varchar(130)',
          'isa' => 'str',
          'size' => 130,
          'label' => '最大圖',
        ),
    ),
  'thumb' => array( 
      'name' => 'thumb',
      'attributes' => array( 
          'type' => 'varchar(200)',
          'isa' => 'str',
          'size' => 200,
          'label' => '縮圖',
          'renderAs' => 'ThumbImageFileInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'image' => array( 
      'name' => 'image',
      'attributes' => array( 
          'type' => 'varchar(200)',
          'isa' => 'str',
          'size' => 200,
          'label' => '主圖',
          'renderAs' => 'ThumbImageFileInput',
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
  'ordering' => array( 
      'name' => 'ordering',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'default' => 0,
          'label' => '排序編號',
        ),
    ),
);
        $this->columnNames     = array( 
  'product_id',
  'title',
  'large',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_images';
        $this->modelClass      = 'ProductBundle\\Model\\ProductImage';
        $this->collectionClass = 'ProductBundle\\Model\\ProductImageCollection';
        $this->label           = '產品圖';
        $this->relations       = array( 
  'product' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ProductImageSchema',
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
