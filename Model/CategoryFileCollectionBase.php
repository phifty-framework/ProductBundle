<?php
namespace ProductBundle\Model;

class CategoryFileCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\ProductBundle\\Model\\CategoryFileSchemaProxy';
const model_class = '\\ProductBundle\\Model\\CategoryFile';
const table = 'category_files';


}
