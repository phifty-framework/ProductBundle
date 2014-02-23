<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\FeatureCollection;
use ProductBundle\Model\Product;
use ProductBundle\Model\ProductCollection;

class ProductController extends Controller
{

    public function getAllCategories() {
        $cates = new CategoryCollection;
        $cates->where(array( 'lang' => kernel()->locale->current() ));
        $cates->order('created_on', 'desc');
        return $cates;
    }

    public function getCategoryProducts($category)
    {
        $products = new ProductCollection;
        $products->join( new \ProductBundle\Model\ProductCategory , "LEFT" );
        $products->where(array(
            'product_category_junction.category_id' => (int) $category->id,
            'hide' => false ,
            'status' => 'publish',
        ));
        $products->order('created_on','desc');
        return $products;
    }

    public function getAllProducts($lang) {
        $allProducts = new ProductCollection;
        $allProducts->where(array( 'lang' => $lang, 'hide' => false, 'status' => 'publish' ));
        $allProducts->order('created_on', 'desc');
        return $allProducts;
    }

    public function itemAction($id, $lang = null, $name = null)
    {
        $product = new Product( (int) $id );
        if ( ! $product->id ) {
            return $this->redirect('/');
        }

        $args = array();
        $args['allProductCategories'] = $this->getAllCategories();
        $args['page_title']        = $product->getPageTitle();
        $args['product'] = $product;

        if ( isset($product->category) ) {
            $args['productCategory'] = $product->category;
        }
        if ( isset($product->categories) ) {
            $args['productCategories'] = $product->categories;
        }

        if ( $bundle = kernel()->bundle('CartBundle') ) {
            $args['cart'] = \CartBundle\Cart::getInstance();
        }
        return $this->render( 'product_item.html' , $args);
    }

    public function byCategoryIdAction($id, $lang = null, $name = null) 
    {
        $lang = $lang ?: kernel()->locale->current();
        $cates = $this->getAllCategories();
        $currentCategory = new Category(intval($id));
    }


    public function byCategoryHandleAction($handle, $lang = null, $name = null)
    {
        $lang = $lang ?: kernel()->locale->current();
        $cates = $this->getAllCategories();
        $currentCategory = new Category(array( 'handle' => $handle, 'lang' => $lang ));
        $products = $this->getCategoryProducts($currentCategory);
        $allProducts = $this->getAllProducts($lang);
        return $this->render( 'product_list.html', array(
            'page_title'               => $currentCategory->name,
            'current_product_category' => $currentCategory,
            'all_product_categories'   => $cates,
            'products'                 => $products,
            'all_products'             => $allProducts,
        ));
    }

    public function listAction()
    {
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
        $products->order('created_on','desc');
        return $this->render( 'product_list.html', array(
            'page_title'               => $currentCategory->name,
            'all_product_categories'   => $cates,
            'all_products'             => $allProducts,
            'current_product_category' => $currentCategory,
            'products'                 => $products,
        ));
    }

    public function searchAction()
    {
        $lang = kernel()->locale->current();
        $keyword = $this->request->param('term');
        $products = new ProductCollection;
        $products->where()
                ->equal('lang',$lang)
                ->equal('status','publish')
                ->equal('hide', false)
                ->group()
                    ->like('content',"%$keyword%")
                    ->or()->like('name',"%$keyword%")
                    ->or()->like('spec',"%$keyword%")
                    ->or()->like('sn',"%$keyword%")
                ->ungroup()
                ;
        return $this->render( 'product_list.html', array(
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
        return $this->render( 'product_item.html' , array( 
            'productCategories' => $cates,
            'product' => $product,
        ));
    }



}

