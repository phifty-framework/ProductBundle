<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use ProductBundle\Model\ProductCollection;
use SQLBuilder\QueryBuilder;
use InvalidArgumentException;

/**
 * Testing http://phifty.dev/=/product/search?keyword=Product&page=3&categories[]=1&categories[]=2
 *
 * keyword: in description, content, subtitle, name
 * categories: [ 1, 2, 3 ]
 * features: [ 1, 2, 3 ]
 */

class ProductSearchController extends Controller
{
    public $lastQuery;

    public $countQuery;

    public function getPageSize()
    {
        return $this->request->param('pagenum') ?: 10;
    }

    public function getCurrentSearchQuery()
    {
        if (isset($_SESSION['product_search'])) {
            // Load from session
            return array_merge(array(
                'keyword' => '',
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

        $keyword  = '';
        $lang     = kernel()->locale->current();
        $orderBy  = 'created_on';

        $featureIds  = array();
        $categoryIds = array();

        // Initialize the search parameters from form
        // And store the search params in SESSION, we should only update them 
        // when there is a new POST request.
        if (isset($_POST['keyword'])) {

            $keyword  = $this->request->param('keyword');
            $lang     = $this->request->param('lang') ?: $lang;
            $orderBy  = $this->request->param('order') ?: $orderBy;
            $featureIds = $this->request->param('features') ?: $featureIds;
            $categoryIds = $this->request->param('categories') ?: $categoryIds;

        } elseif (isset($_SESSION['product_search'])) {
            $searchParams = $this->getCurrentSearchQuery();
            $keyword  = $searchParams['keyword'];
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


        $selects = array(
            'p.id',
            'p.name',
            'p.thumb',
            'p.image',
            'p.subtitle',
            'p.content',
            'p.lang',
            'p.category_id',
            'p.description',
            'p.sn',
        );
        $selectQuery = 'SELECT ' . join(',',$selects) . ' FROM products p';
        $countQuery = 'SELECT count(*) as cnt,p.id FROM products p';
        $whereQuery = array();

        $driver = $collection->getReadQueryDriver();
        $q = new QueryBuilder;
        $q->driver = $driver;

        if ( trim($keyword) ) {
            $keyword = '%'. $keyword . '%';
            $whereQuery[] = '(' . join(' OR ',array( 
                'p.name LIKE ' . $driver->quote($keyword),
                'p.subtitle LIKE ' . $driver->quote($keyword),
                'p.content LIKE ' . $driver->quote($keyword),
            )) . ')';
        }

        if ($lang) {
            $whereQuery[] = sprintf("p.lang = '%s'",$lang);
        }

        $whereQuery[] = sprintf("p.status = '%s'",'publish');

        if (! empty($featureIds)) {
            // use AND
            foreach( $featureIds as $id ) {
                $selectQuery .= " LEFT JOIN product_feature_junction pf{$id} ON (pf{$id}.product_id = p.id) ";
                $countQuery .= " LEFT JOIN product_feature_junction pf{$id} ON (pf{$id}.product_id = p.id) ";
                $whereQuery[] = sprintf("pf{$id}.feature_id = %d", $id);
            }
            // $whereQuery[] = 'pf.feature_id IN (' . join(',', $featureIds) . ')';
        }

        if ( ! empty($categoryIds) ) {
            foreach( $categoryIds as $id ) {
                $selectQuery .= " LEFT JOIN product_category_junction pc{$id} ON (pc{$id}.product_id = p.id) ";
                $countQuery .= " LEFT JOIN product_category_junction pc{$id} ON (pc{$id}.product_id = p.id) ";
                $whereQuery[] = sprintf("(pc{$id}.category_id = %d OR p.category_id = %d)", $id, $id);
            }
            // $whereQuery[] = '( pc.category_id IN (' . join(',', $categoryIds) . ')'
            // . ' OR p.category_id IN (' . join(',', $categoryIds) . '))';
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
        $count = (int) \LazyRecord\ConnectionManager::getInstance()
                    ->prepareAndExecute($dsId, $countQuery,array())
                    ->fetchColumn();
        return array( $collection , $count );
    }

    public function getCollection() {
        return new ProductCollection;
    }

    public function indexAction() {
        list($collection, $count) = $this->applySearchQuery();
        return $this->toJson(array(
            'total' => $count,
            'pageSize' => $this->getPageSize(),
            'pages' => ceil($count / $this->getPageSize()),
            'products' => $collection->toArray(),
            // 'query' => $this->lastQuery,
            // 'countQuery' => $this->countQuery,
        ));
    }

}



