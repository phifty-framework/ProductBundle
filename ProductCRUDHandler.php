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


class ProductCRUDHandler extends \AdminUI\CRUDHandler
{

    /* CRUD Attributes */
    public $modelClass = 'ProductBundle\\Model\\Product';
    public $crudId     = 'product';
    public $templateId = 'product';
    public $listColumns = array(
        'id',
        'thumb',
        'name',
        'subtitle',
        'sn',
    );

    // The right columns should be register from MetaData plugin
    // Please see I18N/I18N.php for example.
    public $listRightColumns = array(
        'updated_on',
        'created_on',
    );


    public $quicksearchFields = array('name');

    public $canBulkEdit = true;


    // XXX: Might move into Plugin CRUDHandler
    public function init()
    {
        $this->bundle = \ProductBundle\ProductBundle::getInstance();

        parent::init();

        if (  kernel()->bundle('StatusPlugin') ) {
            array_insert( $this->listColumns, 3, 'status' );
        }
        if ( $this->bundle->config( 'with_quicksearch' ) ) {
            $this->quicksearchFields = array( 'name' , 'content' );
            if ( $this->bundle->config('with_subtitle') ) {
                $this->quicksearchFields[] = 'subtitle';
            }
            if ( $this->bundle->config('with_sn') ) {
                $this->quicksearchFields[] = 'sn';
            }
        }

        if ( $this->bundle->config( 'with_price' ) ) {
            array_insert( $this->listColumns, -1 , 'price' );
        }

        // set thumb column formatter to display product image
        $this->setFormatter('thumb' , function($record) {
            if ( $record->thumb ) {
                return sprintf('<img style="margin:0px;padding:0px;" height="64" src="/%s"/>',$record->thumb);
            }
        });
    }

    public function editRegionAction() 
    {
        $this->editRegionActionPrepare();
        $bundle = $this->bundle;

        if ( $this->currentRecord && $this->currentRecord->id ) {
            $id = $this->currentRecord->id;

            if ( $bundle->config('with_types') ) 
                $this->assign( 'productTypes' , $this->currentRecord->types->items() );

            if ( $bundle->config('with_images') ) 
                $this->assign( 'productImages' , $this->currentRecord->images->items() );

            if ( $bundle->config('with_features') ) {
                if ( $features = $this->currentRecord->features ) {
                    $this->assign( 'productFeatures' , $features->items() );
                }
            }

            if ( $bundle->config('with_resources') ) {
                $resources = $this->currentRecord->resources;
                $this->assign( 'productResources' , $resources->items() );
            }
        }

        if ( $bundle->config('with_features') ) {
            $features = new FeatureCollection;
            $this->assign( 'features' , $features->items() );
        }
        return $this->renderCrudEdit();
    }


    public function getCollection()
    {
        $collection = parent::getCollection();


        // if the category is specified from REQUEST, we should just filter collection 
        // with the category id for the list view.
        $categoryId         = $this->getCurrentCategoryId();
        if ( $categoryId ) {
            if ( $this->bundle->config('with_multicategory') ) {
                $collection->join( new \ProductBundle\Model\ProductCategory, "LEFT");

                // currently this works for MySQL
                // the select as "product_category_junction_category_id" does not work here.
                $collection->where( array( 'product_category_junction.category_id' => $categoryId ) );
                return $collection;
            } else {
                // for single category mode.
                $collection->where( array( 'category_id' => $categoryId ) );
            }
        }
        $this->orderCollection($collection);
        return $collection;
    }


    public function getCurrentCategoryId()
    {
        return (int) $this->request->param('category_id');
    }


    /**
     * Return current selected category record
     */
    public function getCurrentCategory()
    {
        static $category;
        if ( $category ) {
            return $category;
        }

        $category           = new Category;
        if ( $categoryId = $this->getCurrentCategoryId() ) {
            $category->load( $categoryId );
        }
        return $category;
    }


    public function getAllCategories()
    {
        return new CategoryCollection;
    }

    public function getCategories()
    {
        // TODO: we may use the getCollection method from CategoryCRUDHandler
        $categoryCollection = new CategoryCollection;
        if ( $this->isI18NEnabled() ) {
            if ( $lang = $this->request->param('_filter_lang') ) {
                $categoryCollection->where()->equal('lang', $lang);
            }
        }
        return $categoryCollection;
    }





    public function listRegionAction()
    {
        $category = $this->getCurrentCategory();
        $categoryCollection = $this->getCategories();

        // for the filter panel.
        $this->assignVars(array(
            'categoryItems'   => $categoryCollection,
            'categoryId'      => $this->getCurrentCategoryId(),
            'categoryCurrent' => $category,
        ));
        return parent::listRegionAction();
    }
}

