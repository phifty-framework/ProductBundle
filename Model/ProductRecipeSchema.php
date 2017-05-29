<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;

if( kernel()->bundle('RecipeBundle') ) {

class ProductRecipeSchema extends DeclareSchema
{
    public function schema()
    {
        $this->column('product_id')->integer();
        $this->column('recipe_id')->integer();

        $this->belongsTo('recipe','RecipeBundle\\Model\\Recipe','id','recipe_id');
        $this->belongsTo('product','ProductBundle\\Model\\ProductSchema','id','product_id');
    }
}

}
