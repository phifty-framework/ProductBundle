<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class ProductSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'name',
  1 => 'subtitle',
  2 => 'sn',
  3 => 'description',
  4 => 'content',
  5 => 'spec',
  6 => 'zoom_image',
  7 => 'is_cover',
  8 => 'orig_price',
  9 => 'price',
  10 => 'external_link',
  11 => 'token',
  12 => 'hide',
  13 => 'options_content',
  14 => 'status',
  15 => 'id',
  16 => 'lang',
  17 => 'thumb',
  18 => 'image',
  19 => 'created_on',
  20 => 'updated_on',
  21 => 'created_by',
  22 => 'updated_by',
);
    public static $column_hash = array (
  'name' => 1,
  'subtitle' => 1,
  'sn' => 1,
  'description' => 1,
  'content' => 1,
  'spec' => 1,
  'zoom_image' => 1,
  'is_cover' => 1,
  'orig_price' => 1,
  'price' => 1,
  'external_link' => 1,
  'token' => 1,
  'hide' => 1,
  'options_content' => 1,
  'status' => 1,
  'id' => 1,
  'lang' => 1,
  'thumb' => 1,
  'image' => 1,
  'created_on' => 1,
  'updated_on' => 1,
  'created_by' => 1,
  'updated_by' => 1,
);
    public static $mixin_classes = array (
  0 => 'CommonBundle\\Model\\Mixin\\MetaSchema',
  1 => 'CommonBundle\\Model\\Mixin\\ImageSchema',
  2 => 'I18N\\Model\\Mixin\\I18NSchema',
  3 => 'StatusPlugin\\Model\\Mixin\\StatusSchema',
);
    public static $column_names_include_virtual = array (
  0 => 'name',
  1 => 'subtitle',
  2 => 'sn',
  3 => 'description',
  4 => 'content',
  5 => 'spec',
  6 => 'zoom_image',
  7 => 'is_cover',
  8 => 'orig_price',
  9 => 'price',
  10 => 'external_link',
  11 => 'token',
  12 => 'hide',
  13 => 'options_content',
  14 => 'status',
  15 => 'id',
  16 => 'lang',
  17 => 'thumb',
  18 => 'image',
  19 => 'created_on',
  20 => 'updated_on',
  21 => 'created_by',
  22 => 'updated_by',
);

    const schema_class = 'ProductBundle\\Model\\ProductSchema';
    const collection_class = 'ProductBundle\\Model\\ProductCollection';
    const model_class = 'ProductBundle\\Model\\Product';
    const model_name = 'Product';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'products';
    const label = 'Product';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(256)',
          'isa' => 'str',
          'size' => 256,
          'label' => '產品名稱',
          'renderAs' => 'TextInput',
          'widgetAttributes' => array( 
              'size' => 30,
            ),
        ),
    ),
  'subtitle' => array( 
      'name' => 'subtitle',
      'attributes' => array( 
          'type' => 'varchar(256)',
          'isa' => 'str',
          'size' => 256,
          'label' => '產品副標題',
          'renderAs' => 'TextInput',
          'widgetAttributes' => array( 
              'size' => 60,
            ),
        ),
    ),
  'sn' => array( 
      'name' => 'sn',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '產品序號',
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '產品敘述',
        ),
    ),
  'content' => array( 
      'name' => 'content',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '產品內文',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'spec' => array( 
      'name' => 'spec',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '產品規格',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'zoom_image' => array( 
      'name' => 'zoom_image',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '產品放大圖',
          'renderAs' => 'ThumbImageFileInput',
          'widgetAttributes' => array( 
            ),
        ),
    ),
  'is_cover' => array( 
      'name' => 'is_cover',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'renderAs' => 'CheckboxInput',
          'widgetAttributes' => array( 
            ),
          'label' => '封面產品',
        ),
    ),
  'orig_price' => array( 
      'name' => 'orig_price',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'label' => '產品原價',
        ),
    ),
  'price' => array( 
      'name' => 'price',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'label' => '產品售價',
        ),
    ),
  'external_link' => array( 
      'name' => 'external_link',
      'attributes' => array( 
          'type' => 'varchar(256)',
          'isa' => 'str',
          'size' => 256,
          'label' => '外部連結',
          'renderAs' => 'TextInput',
          'widgetAttributes' => array( 
              'size' => 70,
            ),
        ),
    ),
  'token' => array( 
      'name' => 'token',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => 'Private Token',
          'desc' => 'Users can see hidden products through this private token.',
        ),
    ),
  'hide' => array( 
      'name' => 'hide',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'default' => false,
          'label' => '隱藏這個產品',
          'desc' => 'Do not show this product in front-end page',
        ),
    ),
  'options_content' => array( 
      'name' => 'options_content',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'label' => '選配',
        ),
    ),
  'status' => array( 
      'name' => 'status',
      'attributes' => array( 
          'type' => 'varchar(16)',
          'isa' => 'str',
          'validValues' => array( 
              '草稿' => 'draft',
              '公開發佈' => 'publish',
            ),
          'size' => 16,
          'default' => 'publish',
          'label' => '儲存為',
          'renderAs' => 'SelectInput',
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
  'created_on' => array( 
      'name' => 'created_on',
      'attributes' => array( 
          'type' => 'timestamp',
          'isa' => 'DateTime',
          'timezone' => true,
          'null' => true,
          'renderAs' => 'DateTimeInput',
          'widgetAttributes' => array( 
            ),
          'label' => '建立於',
          'default' => function() {
                return date('c');
            },
        ),
    ),
  'updated_on' => array( 
      'name' => 'updated_on',
      'attributes' => array( 
          'type' => 'timestamp',
          'isa' => 'DateTime',
          'timezone' => true,
          'null' => true,
          'renderAs' => 'DateTimeInput',
          'widgetAttributes' => array( 
            ),
          'default' => function() {
                return date('c');
            },
          'label' => '更新時間',
        ),
    ),
  'created_by' => array( 
      'name' => 'created_by',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'refer' => 'User\\Model\\User',
          'default' => function() {
                if ( isset($_SESSION) ) {
                    return kernel()->currentUser->id;
                }
            },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '建立者',
        ),
    ),
  'updated_by' => array( 
      'name' => 'updated_by',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'refer' => 'User\\Model\\User',
          'default' => function() {
                if ( isset($_SESSION) ) {
                    return kernel()->currentUser->id;
                }
            },
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
            ),
          'label' => '更新者',
        ),
    ),
);
        $this->columnNames     = array( 
  'name',
  'subtitle',
  'sn',
  'description',
  'content',
  'spec',
  'zoom_image',
  'is_cover',
  'orig_price',
  'price',
  'external_link',
  'token',
  'hide',
  'options_content',
);
        $this->primaryKey      = 'id';
        $this->table           = 'products';
        $this->modelClass      = 'ProductBundle\\Model\\Product';
        $this->collectionClass = 'ProductBundle\\Model\\ProductCollection';
        $this->label           = 'Product';
        $this->relations       = array( 
  'created_by' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'self_column' => 'created_by',
      'foreign_schema' => 'User\\Model\\User',
      'foreign_column' => 'id',
    ),
)),
  'updated_by' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'self_column' => 'updated_by',
      'foreign_schema' => 'User\\Model\\User',
      'foreign_column' => 'id',
    ),
)),
  'product_features' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductFeatureSchema',
    ),
)),
  'features' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'relation_junction' => 'product_features',
      'relation_foreign' => 'feature',
    ),
)),
  'product_products' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductProductSchema',
    ),
)),
  'related_products' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'relation_junction' => 'product_products',
      'relation_foreign' => 'related_product',
    ),
)),
  'images' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductImageSchema',
      'order' => array( 
          array( 
              'ordering',
              'ASC',
            ),
        ),
    ),
)),
  'properties' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductPropertySchema',
      'order' => array( 
          array( 
              'ordering',
              'ASC',
            ),
        ),
    ),
)),
  'types' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductTypeSchema',
    ),
)),
  'resources' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ResourceSchema',
    ),
)),
  'files' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductFileSchema',
    ),
)),
  'product_categories' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\ProductSchema',
      'foreign_column' => 'product_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductCategorySchema',
      'renderable' => false,
    ),
)),
  'categories' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'relation_junction' => 'product_categories',
      'relation_foreign' => 'category',
      'filter' => function($collection) { 
                    $collection->order('lang','desc');
                    return $collection;
                },
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

}
