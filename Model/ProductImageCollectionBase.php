<?php
namespace ProductBundle\Model;

class ProductImageCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\ProductBundle\\Model\\ProductImageSchemaProxy';
const model_class = '\\ProductBundle\\Model\\ProductImage';
const table = 'product_images';


}
