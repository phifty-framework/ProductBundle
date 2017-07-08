<?php

namespace ProductBundle;

use Phifty\Bundle;
use Phifty\Region;
use Phifty\Web\RegionPager;

use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\Category;
use ProductBundle\Model\ProductImage;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\Feature;
use ProductBundle\Model\FeatureCollection;
use ProductBundle\Model\Product;
use ProductBundle\Model\FeaturedProduct;
use ProductBundle\Model\FeaturedProductCollection;

use UseCaseBundle\Model\UseCaseCollection;
use Phifty\CollectionUtils;

class FeaturedProductCRUDHandler extends \AdminUI\CRUDHandler
{
    public $modelClass = FeaturedProduct::class;

    public $crudId     = 'featured-product';

    public $templateId = 'featured_product';

    // public $parentKeyRecordClass = Category::class;
}
