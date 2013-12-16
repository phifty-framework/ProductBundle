<?php
namespace ProductBundle\Model;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;

class Product 
extends \ProductBundle\Model\ProductBase
{
    public function dataLabel()
    {
        if ( $this->lang ) {
            return '[' . _($this->lang) . '] ' .  $this->name;
        }
        return $this->name;
    }

    # has many-to-many relation
    public function getFeatures()
    {
        $collection = new FeatureCollection;
        $collection->join( 'product_feature_rels' )
                ->alias('r')
                ->on()
                    ->equal('r.product_id', array('m.id') );
        $collection->where( array( 'product_id' => $this->id ));
        return $collection;
    }

    function createFeature( $args )
    {
        $f = new Feature;
        $f->create($args);
        $rel = new ProductFeature;
        $rel->create( array( 'product_id' => $this->id , 'feature_id' => $f->id ) );
        $f->product = $this;
        $f->product_feature = $rel;
        return $f;
    }
}
