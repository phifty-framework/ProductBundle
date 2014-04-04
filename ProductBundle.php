<?php
namespace ProductBundle;
use Phifty\Bundle;
use Phifty\Region;
use Phifty\Web\RegionPager;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\Category;
use ProductBundle\Model\Product;
use ProductBundle\Model\ProductCollection;
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
            // product bundle scope config
            'lang' => true,
            'DefaultRoutes'     => false,
            'upload_dir' => 'upload',
            'auto_resize' => false,

            'Product' => array( 
                'sn'              => false,
                'desc'            => false,
                'quicksearch'     => false,

                // hide product
                'private'         => false,

                // 產品售價
                'price'           => false,

                // 產品原價
                'orig_price'      => false,
                'show_link' => false,
                'sellable'        => false,
                'external_link'   => false,
                'status'          => true,
                'seo'             => false,
                'options_content' => false,
                'spec_content'    => false,
                'feature_content' => false,

                'bulk_convert' => false,
                'bulk_copy' => false,

                'cover_image' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'image' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'thumb' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'zoom_image' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'spec_image' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'spec_thumb' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'spec_content_image' => false && array(
                    'size_limit' => null,
                    'size' => array( 'width' => null, 'height' => null ),
                ),
            ),
            'ProductImage' => array(
                'enable' => false,
                'thumb' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'image' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
                'large' => false && array(
                    'size' => array( 'width' => null, 'height' => null ),
                    'size_limit' => null,
                    'hint' => null,
                ),
            ),
            'ProductCategory' => array(
                'enable'     => true,
                'multicategory' => true,
                'subcategory' => false,
                'seo'         => false,
                'handle' => false,
                'file' => false,
                'desc' => false,
            ),
            'ProductType' => array(
                'enable' => false,
                'quantity'    => false,
                'seo'         => false,
            ),
            'ProductFeature' => array(
                'enable' => false,

            ),
            'ProductFile' => array(
                'enable' => false,
                'hint' => null,
                'size_limit' => null,
                'vip' => false,
            ),
            'ProductSubsection' => array(
                'enable' => false,
                'cover_image' => array(
                    'size_limit' => null,
                    'size' => array( 'width' => null, 'height' => null ),
                ),
            ),
            'ProductLink' => array(
                'enable' => false,
            ),
            'ProductUsecase' => array(
                'enable' => false,
            ),
            'ProductProperty' => array(
                'enable' => false,

            ),
            'ProductResource' => array(
                'enable' => false,

            ),
            'RelatedProduct' => array( 
                'enable' => false,
            ),
            'category'           => true,
            'subcategory'        => false,
            'quicksearch'        => false,
            'private'            => false,
            'price'              => false,
            'quantity'           => false,
            'orig_price'         => false,
            'types'              => false,
            'sellable'           => false,
            'features'           => false,
            'files'              => array(),
            'spec_content'       => false,
            'options_content'    => false,
            'resources'          => false,
            'cover_option'       => false,
            'cover_image'        => array(),
            'zoom_image'         => true,
            'with_lang'          => true,
            'seo'                => false,
            'images'        => array(),
            // 'bulk' 'features'
            'bulk_copy'          => false,
            'bulk_convert'       => false,
            'external_link'      => false,
            'upload_dir'         => 'upload',
            'DefaultRoutes'     => false,
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

        if ( $this->config('DefaultRoutes') ) {
            $this->route( '/product/search', 'ProductController:search');
            $this->route( '/product', 'ProductController:list');
            $this->route( '/product/:id(/:lang/:name)', 'ProductController:item');
            $this->route( '/p/:id(/:lang/:name)', 'ProductController:item');

            /**
             * product category
             *
             * /pc/h/category-handle/en/產品類別
             * /pc/id/1/zh_TW/產品類別
             */
            $this->route( '/pc/h/:handle(/:lang/:name)', 'ProductController:byCategoryHandle'); // categoryAction
            $this->route( '/pc/id/:id(/:lang/:name)',    'ProductController:byCategoryId'); // categoryAction
        }

        $this->expandRoute( '/bs/product',          'ProductCRUDHandler');
        $this->expandRoute( '/bs/product_category', 'CategoryCRUDHandler');
        $this->expandRoute( '/bs/product_category_file', 'CategoryFileCRUDHandler');
        $this->expandRoute( '/bs/product_feature' , 'FeatureCRUDHandler');
        $this->expandRoute( '/bs/product_resource', 'ProductResourceCRUDHandler');
        $this->expandRoute( '/bs/product_image' ,   'ProductImageCRUDHandler');


        if ( $this->config('ProductType.enable') ) {
            $this->expandRoute( '/bs/product_file' ,    'ProductFileCRUDHandler');
        }

        if ( $this->config('ProductType.enable') ) {
            $this->expandRoute( '/bs/product_type', 'ProductTypeCRUDHandler' );
        }

        if ( $this->config('ProductSubsection.enable') ) {
            $this->expandRoute( '/bs/product_subsection', 'ProductSubsectionCRUDHandler' );
        }

        $this->addCRUDAction('ProductType');
        $this->addCRUDAction('Feature');
        $this->addCRUDAction('ProductFeature');
        $this->addCRUDAction('Resource');
        $this->addCRUDAction('ProductProperty');
        $this->addCRUDAction('ProductProduct');
        $this->addCRUDAction('ProductUseCase');
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
            kernel()->action->registerAction('ProductBundle\\Action\\SortProductUseCase',
                '@ActionKit/RecordAction.html.twig', array(
                    'base_class' => 'SortablePlugin\\Action\\SortRecordAction',
                    'record_class' => 'ProductBundle\\Model\\ProductUseCase',
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
            $this->addCRUDAction('ProductRecipe');
        }

        $self = $this;

        if ( $this->config('sitemap') ) {
            $this->route( '/product_sitemap.xml' ,   'SiteMapController:index');
            kernel()->event->register('sitemap.index', function($sitemapBundle) use ($self) {
                $sitemapBundle->registerIndexPath('/product_sitemap.xml');
            });
        }

        kernel()->event->register( 'adminui.init_menu' , function($menu) use ($self) {
            $bundle = kernel()->bundle('ProductBundle');
            $folder = $menu->createMenuFolder( _('產品') );
            $folder->createCrudMenuItem( 'product', _('產品管理') );

            if ( $bundle->config('ProductCategory.enable') ) {
                $folder->createCrudMenuItem('product_category', _('產品類別管理') );
            }
            if ( $bundle->config('ProductFeature.enable') ) {
                $folder->createCrudMenuItem( 'product_feature', _('產品功能項目管理') );
            }
        });
    }
}
