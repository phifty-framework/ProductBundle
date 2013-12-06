<?php
namespace ProductBundle;

/**

Columns:

  with_sn:
  with_external_link:
  with_category: 
  with_images:
  with_types:
  with_resources:
  with_files:
  with_features:
  with_seo:
  with_cover_option:
  with_price:
  with_subcategory:
  with_zoom_image:
  with_lang:
  with_multicategory: Support multiple category
  cover:
    image:
      size_limit: 600
      resize_width: 600
      size:
        width: 300
        height: 300
    thumb:
      size_limit: 600
      resize_width: 300
      size:
        width: 120
        height: 120
  images:
    image:
      size_limit: 600
      resize_width: 600
      size:
        width: 300
        height: 300
    thumb:
      size_limit: 600
      resize_width: 300
      size:
        width: 120
        height: 120
  file:
    size_limit: 1024
  hints:
    Product:
      image: 這裡放封面主圖
      thumb: 這裡放封面縮圖
      zoom_image: 這裡放最大圖
    ProductImage:
      thumb: 附圖縮圖
      image: 附圖主圖
      large: 附圖最大圖

Fetaures:

  with_quicksearch:
  with_bulk_convert:
  with_bulk_copy:

*/
use Phifty\Bundle;
use Phifty\Region;
use Phifty\Web\RegionPager;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\Category;
use ProductBundle\Model\ProductImage;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\Feature;
use ProductBundle\Model\FeatureCollection;
use CRUD\CollectionChooser;

function array_insert( & $array , $pos = 0 , $elements )
{
    array_splice( $array, $pos , 0 , (array) $elements );
}


class ProductChooser extends CollectionChooser 
{
    public $collectionClass = 'ProductBundle\\Model\\ProductCollection';
}

class FeatureChooser extends CollectionChooser
{
    public $collectionClass = 'ProductBundle\\Model\\FeatureCollection';
}

class ProductBundle extends Bundle 
{

    public function defaultConfig() {
        return array(
            'with_sn'            => true,
            'with_desc'          => true,
            'with_category'      => true,
            'with_subcategory'   => true,
            'with_quicksearch'   => true,
            'with_private'       => true,
            'with_price'         => true,
            'with_types'         => true,
            'with_images'        => true,
            'with_features'      => true,
            'with_files'         => true,
            'with_spec'          => true,
            'with_resources'     => true,
            'with_cover_option'  => true,
            'with_cover_image'   => true,
            'with_zoom_image'    => true,
            'with_lang'          => true,
            'with_seo'           => true,
            // 'bulk' 'features'
            'with_bulk_copy'     => true,
            'with_bulk_convert'  => true,
            'with_external_link' => true,
            'upload_dir'         => 'static/upload',
        );
    }

    public function assets()
    {
        return array('phifty-plugin-product');
    }

    public function init()
    {
        $this->expandRoute( '/=/product/chooser', 'ProductChooser');
        $this->expandRoute( '/=/product_feature/chooser', 'FeatureChooser');

        $this->route( '/=/product/search', 'ProductSearchController');

        $this->expandRoute( '/bs/product',          'ProductCRUDHandler');
        $this->expandRoute( '/bs/product_category', 'CategoryCRUDHandler');
        $this->expandRoute( '/bs/product_category_file', 'CategoryFileCRUDHandler');
        $this->expandRoute( '/bs/product_feature' , 'FeatureCRUDHandler');
        $this->expandRoute( '/bs/product_resource', 'ProductResourceCRUDHandler');
        $this->expandRoute( '/bs/product_image' ,   'ProductImageCRUDHandler');
        $this->expandRoute( '/bs/product_file' ,    'ProductFileCRUDHandler');

        if ( $this->config('with_types') ) {
            $this->expandRoute( '/bs/product_type', 'ProductTypeCRUDHandler' );
        }

        $this->addCRUDAction('ProductType');
        $this->addCRUDAction('Feature');
        $this->addCRUDAction('ProductFeature');
        $this->addCRUDAction('Resource');
        $this->addCRUDAction('ProductProperty');
        $this->addCRUDAction('ProductProduct');

        kernel()->event->register('phifty.before_action', function() {
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductImage', 
                '@ActionKit/RecordAction.html.twig', array( 
                    'base_class' => 'SortableBundle\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductImage',
                ));
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductProperty',
                '@ActionKit/RecordAction.html.twig', array( 
                    'base_class' => 'SortableBundle\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductProperty',
                ));
        });

        kernel()->restful->registerResource('product','ProductBundle\\RESTful\\ProductHandler');

        if ( kernel()->plugin('RecipeBundle') ) {
            $this->addCRUDAction( 'ProductRecipe' , array('Create','Update','Delete') );
        }

        $self = $this;
        kernel()->event->register( 'adminui.init_menu' , function($menu) use ($self) {
            $bundle = kernel()->plugin('ProductBundle');
            $folder = $menu->createMenuFolder( _('Products') );
            $folder->createCrudMenuItem( 'product', _('Product') );

            if ( $bundle->config('with_category') ) {
                $folder->createCrudMenuItem('product_category', _('Product Category') );
            }
            if ( $bundle->config('with_features') ) {
                $folder->createCrudMenuItem( 'product_feature', _('Product Feature') );
            }
        });
    }
}
