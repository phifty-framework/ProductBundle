<?php
namespace ProductBundle\Model;

class ProductRecipeBase  extends \Phifty\Model {
const schema_proxy_class = '\\ProductBundle\\Model\\ProductRecipeSchemaProxy';
const collection_class = '\\ProductBundle\\Model\\ProductRecipeCollection';
const model_class = '\\ProductBundle\\Model\\ProductRecipe';
const table = 'product_recipes';

}
