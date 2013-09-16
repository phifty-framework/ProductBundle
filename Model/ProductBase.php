<?php
namespace ProductBundle\Model;

class ProductBase  extends \Phifty\Model {
const schema_proxy_class = 'ProductBundle\\Model\\ProductSchemaProxy';
const collection_class = 'ProductBundle\\Model\\ProductCollection';
const model_class = 'ProductBundle\\Model\\Product';
const table = 'products';

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

}
