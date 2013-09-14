<?php
namespace ProductBundle\Model;

class ProductTypeBase  extends \Phifty\Model {
const schema_proxy_class = 'ProductBundle\\Model\\ProductTypeSchemaProxy';
const collection_class = 'ProductBundle\\Model\\ProductTypeCollection';
const model_class = 'ProductBundle\\Model\\ProductType';
const table = 'product_types';

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

}
