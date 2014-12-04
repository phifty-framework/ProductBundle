<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\FeatureCollection;
use ProductBundle\Model\Product;
use ProductBundle\Model\ProductCollection;
use Phifty\Web\BootstrapPager;
use ProductBundle\ProductBundle;

class ProductController extends Controller
{

    public function getListTemplate() {
        return "product_list.html";
    }

    public function getItemTemplate() {
        return "product_item.html";
    }


    public function getAllCategories() {
        $cates = new CategoryCollection;
        $cates->where(array( 'lang' => kernel()->locale->current() ));
        $cates->order('created_on', 'desc');
        return $cates;
    }

    public function getCategoryProducts($category)
    {
        $bundle = kernel()->bundle('ProductBundle');
        $products = new ProductCollection;
        if ($bundle->config('ProductCategory.enable')) {
            if ( $bundle->config('ProductCategory.multicategory') ) {
                $products->selectAll();
                $products->where()
                    ->equal('hide', false)
                    ->equal('status', 'publish')
                    ;
                $childCategories = $category->getAllChildCategories(true);
                $cIds = array_map(function($c) { return intval($c->id); }, $childCategories);
                if (!empty($cIds)) {
                    $joinTable = new \ProductBundle\Model\ProductCategory;
                    $joinTable->setAlias("pc");
                    $products->join($joinTable, "LEFT");
                    $products->where()
                        ->in('pc.category_id', $cIds);
                    $products->groupBy($products->getSelected());
                }
            } else {
                $products->where(array(
                  'category_id' => intval($category->id),
                  'hide' => false,
                  'status' => 'publish',
                ));
            }
        }
        $products->order('created_on','DESC')
            ->order('id','DESC')
            ;
        return $products;
    }

    public function getAllProducts($lang) {
        $allProducts = new ProductCollection;
        $allProducts->where(array( 'lang' => $lang, 'hide' => false, 'status' => 'publish' ));
        $allProducts->order('created_on', 'DESC')
            ->order('id', 'DESC');
        return $allProducts;
    }

    public function itemAction($id, $lang = null, $name = null)
    {
        $product = new Product( (int) $id );
        if ( ! $product->id ) {
            return $this->redirect('/');
        }
        if ( $product->lang ) {
            kernel()->locale->speak( $product->lang );
        }

        $args = array();
        $args['page_title']        = $product->getPageTitle();
        $args['page_description']  = strip_tags($product->brief);
        $args['product'] = $product;
        $args['all_product_categories'] = $this->getAllCategories();

        if ( isset($product->category) ) {
            $args['product_category'] = $product->category;
        }
        if ( isset($product->categories) ) {
            $args['product_categories'] = $product->categories;
        }

        if ( $bundle = kernel()->bundle('CartBundle') ) {
            $args['cart'] = \CartBundle\Cart::getInstance();
        }
        return $this->render($this->getItemTemplate(), $args);
    }

    public function byCategoryIdAction($id, $lang = null, $name = null) 
    {
        $page = $this->request->param('page') ?: 1;
        $lang = $lang ?: kernel()->locale->current();
        $cates = $this->getAllCategories();
        $currentCategory = new Category(intval($id));
        if ($currentCategory->id) {
            $products = $this->getCategoryProducts($currentCategory);
        } else {
            $products = $this->getAllProducts($lang);
        }
        $currentCategoryProducts = clone $products;

        $bundle = ProductBundle::getInstance();
        // echo '<pre>' . $products->toSQL() . '</pre>';
        $count = $products->queryCount();

        $page = $this->request->param('page') ?: 1;
        $pager = new BootstrapPager($page, $count, $bundle->config('Product.page_size') ?: 5); // this calculates pages
        $products->page($page, $pager->pageSize);

        $allProducts = $this->getAllProducts($lang);
        return $this->render($this->getListTemplate(), array(
            'page_title'               => $currentCategory->name,
            'page_description'         => $currentCategory->name,
            'product_category'         => $currentCategory,
            'product_category_products'=> $currentCategoryProducts,
            'all_product_categories'   => $cates,
            'products'                 => $products,
            'all_products'             => $allProducts,
            'pager'                    => $pager,
            'product_pager'            => $pager,
        ));
    }

    public function byCategoryHandleAction($handle, $lang = null, $name = null)
    {
        $bundle = kernel()->bundle('ProductBundle');

        $lang = $lang ?: kernel()->locale->current();
        $cates = $this->getAllCategories();
        $currentCategory = new Category(array( 'handle' => $handle, 'lang' => $lang ));
        if ( $currentCategory->id ) {
            $products = $this->getCategoryProducts($currentCategory);
        } else {
            $products = $this->getAllProducts($lang);
        }
        $currentCategoryProducts = clone $products;

        // echo '<pre>' . $products->toSQL() . '</pre>';
        $count = $products->queryCount();
        $page = $this->request->param('page') ?: 1;
        $pager = new BootstrapPager($page, $count, $bundle->config('Product.page_size') ?: 5 ); // this calculates pages
        $products->page( $page, $pager->pageSize );

        $allProducts = $this->getAllProducts($lang);
        return $this->render($this->getListTemplate(), array(
            'page_title'               => $currentCategory->name,
            'product_category'         => $currentCategory,
            'product_category_products'=> $currentCategoryProducts,
            'all_product_categories'   => $cates,
            'products'                 => $products,
            'all_products'             => $allProducts,
            'pager'                    => $pager,
            'product_pager'            => $pager,
        ));
    }

    public function listAction()
    {
        $bundle = kernel()->bundle('ProductBundle');
        $page = $this->request->param('page') ?: 1;
        $cId = $this->request->param('category_id');
        $lang = kernel()->locale->current();

        $cates = $this->getAllCategories();

        $currentCategory = new Category( (int) $cId );

        // loaded
        if( $currentCategory->id ) {
            $products = $this->getCategoryProducts($currentCategory);
        } else {
            $products = $this->getAllProducts($lang);
        }

        $allProducts = $this->getAllProducts($lang);

        $count = $products->queryCount();
        $pager = new BootstrapPager($page, $count, $bundle->config('Product.page_size') ); // this calculates pages
        $products->page( $page, $pager->pageSize );

        return $this->render($this->getListTemplate(), array(
            'page_title'               => $currentCategory->name,
            'all_product_categories'   => $cates,
            'all_products'             => $allProducts,
            'product_category'         => $currentCategory,
            'products'                 => $products,
            'pager'                    => $pager,
            'product_pager'            => $pager,
            'product_count'            => $count,
        ));
    }

    /**
     * A simple term search action products
     */
    public function searchAction()
    {
        $lang = kernel()->locale->current();
        $term = $this->request->param('term');
        $products = new ProductCollection;
        $products->where()
                ->equal('lang', $lang)
                ->equal('status','publish')
                ->equal('hide', false)
                ->group()
                    ->like('content',"%$term%")
                    ->or()->like('name',"%$term%")
                    ->or()->like('spec_content',"%$term%")
                    ->or()->like('description',"%$term%")
                    ->or()->like('sn',"%$term%")
                ->ungroup()
                ;
        return $this->render($this->getListTemplate(), array(
            'search_term' => $term,
            'products'    => $products,
        ));
    }

    public function privateItemAction($token)
    {
        $cates = $this->getAllCategories();
        $product = new Product;
        $product->load(array( 'token' => $token ));
        if ( ! $product->id ) {
            return $this->redirect('/not_found');
        }
        return $this->render($this->getItemTemplate(), array(
            'product_categories' => $cates,
            'product' => $product,
        ));
    }



}

