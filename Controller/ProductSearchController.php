<?php
namespace ProductBundle\Controller;
use Phifty\Controller;
use ProductBundle\Model\ProductCollection;
use SQLBuilder\QueryBuilder;


/**
 * Testing http://phifty.dev/=/product/search?keyword=Product&page=3&categories[]=1&categories[]=2
 *
 * keyword: in description, content, subtitle, name
 * categories: [ 1, 2, 3 ]
 * features: [ 1, 2, 3 ]
 */

class ProductSearchController extends Controller
{

    public function getPageSize() 
    {
        return $this->request->param('pagenum') ?: 10;
    }

    public function applySearchQuery()
    {
        $collection = new ProductCollection;
        $keyword = $this->request->param('keyword');
        $lang = $this->request->param('lang');
        $page = $this->request->param('page');
        $pageSize = $this->getPageSize();
        $orderBy = $this->request->param('order') ?: 'created_on';

        $featureIds = array_map(function($id) { return intval($id); },array_filter($this->request->param('features') ?: array(), function($id) {
            return is_numeric($id);
        }));
        $categoryIds = array_map( function($id) { return intval($id); }, array_filter($this->request->param('categories') ?: array(),function($id) {
            return is_numeric($id);
        }));

        $selects = array('p.*');
        $selectQuery = 'SELECT ' . join(' ',$selects) . ' FROM products p';
        $countQuery = 'SELECT count(*) FROM products p';
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

        if ( ! empty($featureIds) ) {
            $selectQuery .= ' LEFT JOIN product_feature_junction pf ON (pf.product_id = p.id) ';
            $countQuery .= ' LEFT JOIN product_feature_junction pf ON (pf.product_id = p.id) ';
            $whereQuery[] = 'pf.feature_id IN (' . join(',', $featureIds) . ')';
        }

        if ( ! empty($categoryIds) ) {
            $selectQuery .= ' LEFT JOIN product_category_junction pc ON (pc.product_id = p.id) ';
            $countQuery .= ' LEFT JOIN product_category_junction pc ON (pc.product_id = p.id) ';
            $whereQuery[] = '(pc.category_id IN (' . join(',', $categoryIds) . ')'
             . ' OR p.category_id IN (' . join(',', $categoryIds) . '))';
        }

        if ( $page ) {
            $q->limit($pageSize);
            $q->offset( ($page - 1) * $pageSize);
            // var_dump( $q->buildLimitSql() ); 
        }

        if ( ! empty($whereQuery) ) {
            $selectQuery .= ' WHERE ' . join(' AND ', $whereQuery);
            $countQuery .= ' WHERE ' . join(' AND ', $whereQuery);
        }

        $selectQuery .= " ORDER BY p.$orderBy DESC";
        $selectQuery .= $q->buildLimitSql();


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
        list($collection,$count) = $this->applySearchQuery();
        return $this->toJson(array(
            'total' => $count,
            'page_size' => $this->getPageSize(),
            'pages' => ceil($count / $this->getPageSize()),
            'products' => $collection->toArray(),
        ));
    }

}



