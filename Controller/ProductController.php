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

    public function listAction()
    {
        $cId = $this->request->param('category_id');
        $lang = kernel()->locale->current();

        $cates = $this->getCategories();

        $currentCategory = new Category( (int) $cId );
        $products = new ProductCollection;

        if( $cId ) {
            $products->join( new \ProductBundle\Model\ProductCategory , "LEFT" );
            $products->where(array(
                'product_category_junction.category_id' => (int) $cId,
                'hide' => false ,
                'status' => 'publish',
            ));
        } else {
            $products->where(array( 'lang' => $lang , 'hide' => false , 'status' => 'publish' ));
        }

        $allProducts = new ProductCollection;
        $allProducts->where(array( 'lang' => $lang, 'hide' => false, 'status' => 'publish' ));
        $allProducts->order('created_on', 'desc');

        $products->order('created_on','desc');
        return $this->render( 'product_list.html', array(
            'page_title' => $currentCategory->name,
            'productCurrentCategory' => $currentCategory,
            'productCategories'      => $cates,
            'products'               => $products,
            'allProducts'            => $allProducts,
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
        $cates = $this->getCategories();
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

