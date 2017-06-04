<?php
namespace ProductBundle\Controller;
use Phifty\Routing\Controller;
use SiteMap\SiteMap;
use ProductBundle\Model\ProductCollection;

class SiteMapController extends Controller
{
    public function indexAction() {
        $sitemap = new SiteMap();
        $sitemap->includeAll();


        $allProducts = new ProductCollection;
        $allProducts->where(array( 'hide' => false, 'status' => 'publish' ));
        $allProducts->orderBy('created_on', 'desc');
        foreach( $allProducts as $product ) {
            $url = $sitemap->addUrl(kernel()->getHostBaseUrl() . $product->getLink());
            $url->changefreq('weekly')
                ->lastmod( $product->updated_on );
                // ->priority(1.0)
                // ->mobile(1.0);
        }
        header('Content-Type: text/xml; charset=UTF-8');
        echo $sitemap->__toString();
    }
}

