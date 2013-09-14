<?php
namespace ProductBundle\Model;

class ProductFileCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\ProductBundle\\Model\\ProductFileSchemaProxy';
const model_class = '\\ProductBundle\\Model\\ProductFile';
const table = 'product_files';


}
