<?php
namespace ProductBundle\Model;



class ProductCollection 
extends \ProductBundle\Model\ProductCollectionBase
{

    public static function getReadableItems()
    {
        $items = new self;
        $items->where()
            ->equal('status','publish');
        $items->order('created_on','desc');
        return $items;
    }

    
}
