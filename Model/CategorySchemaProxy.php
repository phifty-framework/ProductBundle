<?php
namespace ProductBundle\Model;

use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class CategorySchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'name',
  1 => 'description',
  2 => 'parent_id',
  3 => 'hide',
  4 => 'thumb',
  5 => 'image',
  6 => 'identity',
  7 => 'created_on',
  8 => 'updated_on',
  9 => 'created_by',
  10 => 'updated_by',
  11 => 'id',
  12 => 'lang',
);
    public static $column_hash = array (
  'name' => 1,
  'description' => 1,
  'parent_id' => 1,
  'hide' => 1,
  'thumb' => 1,
  'image' => 1,
  'identity' => 1,
  'created_on' => 1,
  'updated_on' => 1,
  'created_by' => 1,
  'updated_by' => 1,
  'id' => 1,
  'lang' => 1,
);
    public static $mixin_classes = array (
  0 => 'Phifty\\Model\\Mixin\\I18NSchema',
  1 => 'Phifty\\Model\\Mixin\\MetadataSchema',
);
    public static $column_names_include_virtual = array (
  0 => 'name',
  1 => 'description',
  2 => 'parent_id',
  3 => 'hide',
  4 => 'thumb',
  5 => 'image',
  6 => 'identity',
  7 => 'created_on',
  8 => 'updated_on',
  9 => 'created_by',
  10 => 'updated_by',
  11 => 'id',
  12 => 'lang',
);

    const schema_class = 'ProductBundle\\Model\\CategorySchema';
    const collection_class = 'ProductBundle\\Model\\CategoryCollection';
    const model_class = 'ProductBundle\\Model\\Category';
    const model_name = 'Category';
    const model_namespace = 'ProductBundle\\Model';
    const primary_key = 'id';
    const table = 'product_categories';
    const label = 'Category';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'type' => 'varchar(130)',
          'isa' => 'str',
          'size' => 130,
          'label' => 'Category Name',
          'required' => 1,
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'type' => 'text',
          'isa' => 'str',
          'renderAs' => 'TextareaInput',
          'widgetAttributes' => array( 
              'class' => '+=mceEditor',
            ),
        ),
    ),
  'parent_id' => array( 
      'name' => 'parent_id',
      'attributes' => array( 
          'type' => 'integer',
          'isa' => 'int',
          'refer' => 'ProductBundle\\Model\\Category',
          'label' => 'Parent Category',
          'default' => 0,
          'renderAs' => 'SelectInput',
          'widgetAttributes' => array( 
              'allow_empty' => 0,
            ),
        ),
    ),
  'hide' => array( 
      'name' => 'hide',
      'attributes' => array( 
          'type' => 'boolean',
          'isa' => 'bool',
          'label' => 'Hide this category',
        ),
    ),
  'thumb' => array( 
      'name' => 'thumb',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '縮圖',
        ),
    ),
  'image' => array( 
      'name' => 'image',
      'attributes' => array( 
          'type' => 'varchar(128)',
          'isa' => 'str',
          'size' => 128,
          'label' => '圖片',
        ),
    ),
  'identity' => array( 
      'name' => 'identity',
      'attributes' => array( 
          'type' => 'varchar(32)',
          'isa' => 'str',
          'size' => 32,
          'label' => 'Identity',
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
            ),
        ),
    ),
);
        $this->columnNames     = array( 
  'name',
  'description',
  'parent_id',
  'hide',
  'thumb',
  'image',
  'identity',
);
        $this->primaryKey      = 'id';
        $this->table           = 'product_categories';
        $this->modelClass      = 'ProductBundle\\Model\\Category';
        $this->collectionClass = 'ProductBundle\\Model\\CategoryCollection';
        $this->label           = 'Category';
        $this->relations       = array( 
  'created_by' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'self_column' => 'created_by',
      'foreign_schema' => 'User\\Model\\User',
      'foreign_column' => 'id',
    ),
)),
  'updated_by' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'self_column' => 'updated_by',
      'foreign_schema' => 'User\\Model\\User',
      'foreign_column' => 'id',
    ),
)),
  'files' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'foreign_column' => 'category_id',
      'foreign_schema' => 'ProductBundle\\Model\\CategoryFile',
    ),
)),
  'subcategories' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'foreign_column' => 'parent_id',
      'foreign_schema' => 'ProductBundle\\Model\\CategorySchema',
    ),
)),
  'parent' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 4,
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'self_column' => 'parent_id',
      'foreign_schema' => 'ProductBundle\\Model\\Category',
      'foreign_column' => 'id',
    ),
)),
  'category_products' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 2,
      'self_column' => 'id',
      'self_schema' => 'ProductBundle\\Model\\CategorySchema',
      'foreign_column' => 'category_id',
      'foreign_schema' => 'ProductBundle\\Model\\ProductCategorySchema',
    ),
)),
  'products' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 3,
      'relation_junction' => 'category_products',
      'relation_foreign' => 'product',
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }

}
