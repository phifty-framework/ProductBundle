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
use UseCaseBundle\Model\UseCaseCollection;
use Phifty\CollectionUtils;


class ProductCRUDHandler extends \AdminUI\CRUDHandler
{

    /* CRUD Attributes */
    public $modelClass = 'ProductBundle\\Model\\Product';

    public $crudId     = 'product';

    public $templateId = 'product';

    public $listColumns = [
        'id',
        'thumb',
        'name',
        'subtitle',
        'sn',
    ];

    // The right columns should be register from MetaData plugin
    // Please see I18N/I18N.php for example.
    public $listRightColumns = array(
        'updated_on',
        'created_on',
    );


    public $quicksearchFields = array('name');

    public $canBulkEdit = true;


    public function boot()
    {
        parent::boot();

        if ($this->kernel->bundle('StatusPlugin') ) {
            array_insert( $this->listColumns, 3, 'status' );
        }

        if ( $this->bundle->config( 'Product.quicksearch' ) ) {
            $this->quicksearchFields = array( 'name' , 'content' );
            if ( $this->bundle->config('Product.subtitle') ) {
                $this->quicksearchFields[] = 'subtitle';
            }
            if ( $this->bundle->config('Product.sn') ) {
                $this->quicksearchFields[] = 'sn';
            }
            if ( $this->bundle->config('Product.brief') ) {
                $this->quicksearchFields[] = 'brief';
            }
            if ( $this->bundle->config('Product.content') ) {
                $this->quicksearchFields[] = 'content';
            }
        }

        if ($this->bundle->config( 'Product.price' )) {
            array_insert( $this->listColumns, -1 , 'price');
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

            if ( $bundle->config('types') ) 
                $this->assign( 'productTypes' , $this->currentRecord->types->items() );

            if ( $bundle->config('with_images') ) 
                $this->assign( 'productImages' , $this->currentRecord->images->items() );

            if ( $bundle->config('features') ) {
                if ( $features = $this->currentRecord->features ) {
                    $this->assign( 'productFeatures' , $features->items() );
                }
            }

            if ( $bundle->config('resources') ) {
                $resources = $this->currentRecord->resources;
                $this->assign( 'productResources' , $resources->items() );
            }
        }

        if ( $bundle->config('features') ) {
            $features = new FeatureCollection;
            $this->assign( 'features' , $features->items() );
        }
        return $this->renderEdit();
    }

    public function renderEdit($args = array())
    {
        $args['categoriesByLang'] = CollectionUtils::aggregateByLang(
            $this->kernel->locale->available(),
            'ProductBundle\\Model\\CategoryCollection');

        $args['featuresByLang'] = CollectionUtils::aggregateByLang(
            $this->kernel->locale->available(),
            'ProductBundle\\Model\\FeatureCollection');

        $args['productsByLang'] = CollectionUtils::aggregateByLang(
            $this->kernel->locale->available(),
            'ProductBundle\\Model\\ProductCollection');

        $bundle = $this->kernel->bundle('ProductBundle');

        if ( $bundle->config('usecases') ) {
            $args['usecasesByLang'] = CollectionUtils::aggregateByLang(
                $this->kernel->locale->available(),
                \UseCaseBundle\Model\UseCaseCollection::class);
        }

        if ($bundle->config('Product.hide_subcategory')) {
            foreach( $args['categoriesByLang'] as $lang => $collection ) {
                $collection->where()->equal('parent_id', 0);
            }
        }

        return $this->render($this->mustFindTemplate('edit.html.twig') , $args);
    }

    public function getCollection()
    {
        $collection = parent::getCollection();


        // if the category is specified from REQUEST, we should just filter collection 
        // with the category id for the list view.
        $categoryId         = $this->getCurrentCategoryId();
        if ( $categoryId ) {
            if ( $this->bundle->config('ProductCategory.multicategory') ) {
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

