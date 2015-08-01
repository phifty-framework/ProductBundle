<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use SQLBuilder\QueryBuilder;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\Model\FeatureCollection;
use ProductBundle\Model\Product;
use ProductBundle\Model\ProductCollection;
use Phifty\Web\BootstrapPager;
use InvalidArgumentException;
use ProductBundle\ProductBundle;

/**
 * Testing http://phifty.dev/=/product/search?term=Product&page=3&categories[]=1&categories[]=2
 *
 * term: in description, content, subtitle, name
 * categories: [ 1, 2, 3 ]
 * features: [ 1, 2, 3 ]
 */

class ProductSearchController extends Controller
{
    public $lastQuery;

    public $countQuery;

    public function getPageSize()
    {
        return $this->request->param('pagenum') ?: ProductBundle::getInstance()->config('Product.page_size') ?: 5;
    }

    public function getCurrentSearchQuery()
    {
        if (isset($_SESSION['product_search'])) {
            // Load from session
            return array_merge(array(
                'term' => '',
                'lang' => kernel()->locale->current(),
                'order' => 'created_on',
                'features' => array(),
                'categories' => array(),
            ), $_SESSION['product_search']);
        }
        return NULL;
    }

    public function applySearchQuery()
    {
        $collection = new ProductCollection;
        $product = new Product;

        $term  = '';
        $lang     = kernel()->locale->current();
        $orderBy  = 'created_on';

        $featureIds  = array();
        $categoryIds = array();

        // Initialize the search parameters from form
        // And store the search params in SESSION, we should only update them 
        // when there is a new POST request.
        if (isset($_REQUEST['term'])) {
            $term     = trim($this->request->param('term'));
            $lang     = $this->request->param('lang') ?: $lang;
            $orderBy  = $this->request->param('order') ?: $orderBy;
            $featureIds = $this->request->param('features') ?: $featureIds;
            $categoryIds = $this->request->param('categories') ?: $categoryIds;

            // Update session
            $_SESSION['product_search'] = array(
                'term' => $term,
                'order' => $orderBy,
                'features' => $featureIds,
                'categories' => $categoryIds,
            );

        } elseif (isset($_SESSION['product_search'])) {
            $searchParams = $this->getCurrentSearchQuery();
            $term     = $searchParams['term'];
            $lang     = $searchParams['lang'];
            $orderBy  = $searchParams['order'];
            $featureIds  = $searchParams['features'];
            $categoryIds = $searchParams['categories'];
        } else {
            throw new InvalidArgumentException('Invalid Search Parameters');
        }

        // Always get the page number and page size from parameters
        $page     = $this->request->param('page');
        $pageSize = $this->getPageSize();

        // Filter the list
        $featureIds  = array_map('intval', array_filter($featureIds, 'is_numeric'));
        $categoryIds = array_map('intval', array_filter($categoryIds, 'is_numeric'));

        $schema = $product->getSchema();

        // Fetch all available columns
        $selects = array_map(function($n) {
            return "p.$n";
        }, $schema->getColumnNames());

        /*
        $selects = array(
            'p.id',
            'p.name',
            'p.thumb',
            'p.image',
            'p.subtitle',
            'p.content',
            'p.brief',
            'p.lang',
            'p.category_id',
            'p.description',
            'p.sn',
        );
         */

        $selectQuery = 'SELECT ' . join(',',$selects) . ' FROM products p';
        $countQuery = 'SELECT count(*) as cnt,p.id FROM products p';
        $whereQuery = array();

        $driver = $collection->getReadQueryDriver();
        $q = new QueryBuilder;
        $q->driver = $driver;

        if ($term) {
            $termSQL = '%'. $term . '%';
            $whereQuery[] = '('
                . join(' OR ',array(
                    'p.name LIKE ' . $driver->quote($termSQL),
                    'p.subtitle LIKE ' . $driver->quote($termSQL),
                    'p.content LIKE ' . $driver->quote($termSQL),
                    'p.brief LIKE ' . $driver->quote($termSQL),
                  ))
                . ')';
        }

        if ($lang) {
            $whereQuery[] = sprintf("p.lang = %s", $driver->quote($lang));
        }

        // Find out all published products
        $whereQuery[] = sprintf("p.status = %s", $driver->quote('publish'));

        if (! empty($featureIds)) {
            // Features should be intersection
            foreach( $featureIds as $id ) {
                $selectQuery .= " LEFT JOIN product_feature_junction pf{$id} ON (pf{$id}.product_id = p.id) ";
                $countQuery .= " LEFT JOIN product_feature_junction pf{$id} ON (pf{$id}.product_id = p.id) ";
                $whereQuery[] = sprintf("pf{$id}.feature_id = %d", $id);
            }
        }

        if (! empty($categoryIds)) {
            // Categories search should be union
            $categoryWhereQuery = array();
            foreach( $categoryIds as $id ) {
                $selectQuery .= " LEFT JOIN product_category_junction pc{$id} ON (pc{$id}.product_id = p.id) ";
                $countQuery .= " LEFT JOIN product_category_junction pc{$id} ON (pc{$id}.product_id = p.id) ";
                $categoryWhereQuery[] = sprintf("(pc{$id}.category_id = %d OR p.category_id = %d)", $id, $id);
            }
            $whereQuery[] = '(' . join(' OR ', $categoryWhereQuery) . ')';
        }

        if ($page) {
            $q->limit($pageSize);
            $q->offset( ($page - 1) * $pageSize);
        }

        if ( ! empty($whereQuery) ) {
            $selectQuery .= ' WHERE ' . join(' AND ', $whereQuery);
            $countQuery .= ' WHERE ' . join(' AND ', $whereQuery);
        }

        $selectQuery .= " GROUP BY " . join(',',$selects) . " ";
        $selectQuery .= " ORDER BY p.$orderBy DESC";
        $selectQuery .= $q->buildLimitSql();

        $countQuery .= " GROUP BY p.id";
        $countQuery = "SELECT count(*) FROM ($countQuery) AS cnt;";

        $this->lastQuery = $selectQuery;
        $this->countQuery = $countQuery;

        $collection->loadQuery( $selectQuery );
        $dsId = $collection->getSchema()->getReadSourceId();

        // Fetch matched item size
        $result = \LazyRecord\ConnectionManager::getInstance()
                    ->prepareAndExecute($dsId, $countQuery,array())
                    ->fetchColumn();
        return array( $collection , intval($result) );
    }

    public function getAllProducts($lang) {
        $allProducts = new ProductCollection;
        $allProducts->where(array( 'lang' => $lang, 'hide' => false, 'status' => 'publish' ));
        $allProducts->orderBy('created_on', 'DESC')
            ->orderBy('id', 'DESC');
        return $allProducts;
    }

    public function getAllCategories($lang) {
        $cates = new CategoryCollection;
        $cates->where(array( 'lang' => $lang ));
        $cates->orderBy('created_on', 'desc');
        return $cates;
    }

    public function getListTemplate() {
        return "product_list.html";
    }

    public function indexAction() {
        list($products, $total) = $this->applySearchQuery();

        // if the json parameter is specified, we just output the data as json
        // instead of rendering the result with the template.
        if ($this->request->param('json')) {
            return $this->toJson(array(
                'total' => $total,
                'pageSize' => $this->getPageSize(),
                'pages' => ceil($toal / $this->getPageSize()),
                'products' => $products->toArray(),
                // 'query' => $this->lastQuery,
                // 'countQuery' => $this->countQuery,
            ));
        }

        // Show current search category (not used in the logic but used for the view)
        $currentCategory = NULL;
        if (isset($_SESSION['current_product_category'])) {
            $currentCategory = new Category(intval($_SESSION['current_product_category']));
        }
        if ($currentCategoryId = $this->request->param('current_product_category')) {
            $currentCategory = new Category(intval($currentCategoryId));
            $_SESSION['current_product_category'] = $currentCategoryId;
        }

        $params = $this->getCurrentSearchQuery();
        $lang = kernel()->locale->current();

        $page = $this->request->param('page') ?: 1;
        $pager = new BootstrapPager($page, $total, $this->getPageSize()); // this calculates pages

        // echo '<pre>' . $this->lastQuery . '</pre>';

        // The template arguments should follow what we've used in ProductController:listAction
        return $this->render($this->getListTemplate(), array(
            'page_title'               => _('Searching ') . $params['term'],
            'all_product_categories'   => $this->getAllCategories($lang),
            'all_products'             => $this->getAllProducts($lang),
            // 'product_category' => $currentCategory,
            'products'                 => $products,
            'total'                    => $total,
            'pager'                    => $pager,
            'product_pager'            => $pager,
            'product_count'            => $total,
            'search_params'            => $params,

            'product_current_search_category' => $currentCategory,

            'product_search_query' => $this->lastQuery,
            'product_search_count_query' => $this->countQuery,
        ));
    }
}



