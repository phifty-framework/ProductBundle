<?php
namespace ProductBundle;

/**

Columns:

  sn:
  external_link:
  category: 
  with_images:
  types:
  resources:
  with_files:
  with_features:
  with_seo:
  cover_option:
  price:
  subcategory:
  with_zoom_image:
  with_lang:
  multicategory: Support multiple category
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
            'sn'            => true,
            'desc'          => true,
            'category'      => true,
            'subcategory'   => true,
            'with_quicksearch'   => true,
            'private'       => true,
            'price'         => true,
            'orig_price'    => true,
            'types'         => true,
            'sellable'         => true,
            'type_quantity' => true,
            'with_images'        => true,
            'with_features'      => true,
            'with_files'         => true,
            'with_spec'          => true,
            'resources'     => true,
            'cover_option'  => true,
            'cover_image'   => true,
            'with_zoom_image'    => true,
            'with_lang'          => true,
            'with_seo'           => true,
            // 'bulk' 'features'
            'with_bulk_copy'     => true,
            'with_bulk_convert'  => true,
            'external_link' => true,
            'upload_dir'         => 'upload',
        );
    }

    public function assets()
    {
        return array('phifty-plugin-product', 'product-api');
    }

    public function init()
    {
        $this->expandRoute( '/=/product/chooser', 'ProductChooser');
        $this->expandRoute( '/=/product_feature/chooser', 'FeatureChooser');

        $this->route( '/=/product/search', 'ProductSearchController');

        $this->route( '/=/product/autocomplete', 'ProductAutoCompleteController');

        $this->route( '/product', 'ProductController:list');
        $this->route( '/product/:id/:lang/:name', 'ProductController:item');


        $this->expandRoute( '/bs/product',          'ProductCRUDHandler');
        $this->expandRoute( '/bs/product_category', 'CategoryCRUDHandler');
        $this->expandRoute( '/bs/product_category_file', 'CategoryFileCRUDHandler');
        $this->expandRoute( '/bs/product_feature' , 'FeatureCRUDHandler');
        $this->expandRoute( '/bs/product_resource', 'ProductResourceCRUDHandler');
        $this->expandRoute( '/bs/product_image' ,   'ProductImageCRUDHandler');

        if ( $this->config('with_files') ) {
            $this->expandRoute( '/bs/product_file' ,    'ProductFileCRUDHandler');
        }

        if ( $this->config('types') ) {
            $this->expandRoute( '/bs/product_type', 'ProductTypeCRUDHandler' );
        }

        if ( $this->config('subsections') ) {
            $this->expandRoute( '/bs/product_subsection', 'ProductSubsectionCRUDHandler' );
        }

        $this->addCRUDAction('ProductType');
        $this->addCRUDAction('Feature');
        $this->addCRUDAction('ProductFeature');
        $this->addCRUDAction('Resource');
        $this->addCRUDAction('ProductProperty');
        $this->addCRUDAction('ProductProduct');
        $this->addCRUDAction('ProductLink');
        $this->addCRUDAction('ProductSubsection');

        kernel()->event->register('phifty.before_action', function() {
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductImage', 
                '@ActionKit/RecordAction.html.twig', array( 
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductImage',
                ));
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductProperty',
                '@ActionKit/RecordAction.html.twig', array( 
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductProperty',
                ));
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductLink',
                '@ActionKit/RecordAction.html.twig', array(
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductLink',
                ));
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductProduct',
                '@ActionKit/RecordAction.html.twig', array(
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductProduct',
                ));
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductSubsection',
                '@ActionKit/RecordAction.html.twig', array(
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductSubsection',
                ));
        });

        kernel()->restful->registerResource('product','ProductBundle\\RESTful\\ProductHandler');
        kernel()->restful->registerResource('product_type','ProductBundle\\RESTful\\ProductTypeHandler');

        if ( kernel()->bundle('RecipeBundle') ) {
            $this->addCRUDAction( 'ProductRecipe' , array('Create','Update','Delete') );
        }

        $self = $this;
        kernel()->event->register( 'adminui.init_menu' , function($menu) use ($self) {
            $bundle = kernel()->bundle('ProductBundle');
            $folder = $menu->createMenuFolder( _('產品') );
            $folder->createCrudMenuItem( 'product', _('產品管理') );

            if ( $bundle->config('category') ) {
                $folder->createCrudMenuItem('product_category', _('產品類別管理') );
            }
            if ( $bundle->config('with_features') ) {
                $folder->createCrudMenuItem( 'product_feature', _('產品功能項目管理') );
            }
        });
    }
}
