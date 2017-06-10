<?php
namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

class ProductFeatureSchema extends DeclareSchema
{
    # feature relations
    public $table = 'product_feature_junction';

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $this->column('product_id')
            ->integer()
            ->required()
            ->label(_('Product Id'))
            ->refer(ProductSchema::class)
            ;
        $this->column('feature_id')
            ->integer()
            ->required()
            ->label(_('Feature Id'))
            ->refer(FeatureSchema::class);

        $this->belongsTo('product', ProductSchema::class, 'id', 'product_id');
        $this->belongsTo('feature', FeatureSchema::class, 'id', 'feature_id');
    }
}
