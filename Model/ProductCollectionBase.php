<?php
namespace ProductBundle\Model;

class ProductCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\ProductBundle\\Model\\ProductSchemaProxy';
const model_class = '\\ProductBundle\\Model\\Product';
const table = 'products';


}
