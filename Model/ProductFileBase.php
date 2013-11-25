<?php
namespace ProductBundle\Model;

class ProductFileBase  extends \Phifty\Model {
const schema_proxy_class = 'ProductBundle\\Model\\ProductFileSchemaProxy';
const collection_class = 'ProductBundle\\Model\\ProductFileCollection';
const model_class = 'ProductBundle\\Model\\ProductFile';
const table = 'product_files';

public static $column_names = array (
  0 => 'product_id',
  1 => 'title',
  2 => 'vip',
  3 => 'mimetype',
  4 => 'file',
  5 => 'id',
);
public static $column_hash = array (
  'product_id' => 1,
  'title' => 1,
  'vip' => 1,
  'mimetype' => 1,
  'file' => 1,
  'id' => 1,
);
public static $mixin_classes = array (
);

}
