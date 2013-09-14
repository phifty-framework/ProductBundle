<?php
namespace ProductBundle\Model;

class ProductRecipeCollectionBase  extends \LazyRecord\BaseCollection {
const schema_proxy_class = '\\ProductBundle\\Model\\ProductRecipeSchemaProxy';
const model_class = '\\ProductBundle\\Model\\ProductRecipe';
const table = 'product_recipes';

}
