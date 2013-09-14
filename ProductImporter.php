<?php
namespace ProductBundle;

// use ProductBundle\Model\ProductBundle;
use ProductBundle\Model\Category;
use Phifty\Importer;
use DirectoryIterator;
use Excpetion;

class ProductImporter extends Importer
{
    /* data root */
    public $imageDir;
    public $webroot;

    function __construct()
    {
        parent::__construct( 'import-prod-' );
    }

    function setImageBase( $dir )
    {
        $this->imageBase = $dir;
    }

    function traverse_category($lang,$dirinfo,$parent = null,$level = 1)
    {
        $it = new DirectoryIterator($dirinfo->getPathname() );
        foreach ($it as $fileinfo) 
        {
            if( $fileinfo->isDot() )
                continue;

            /* skip files start with "." */
            if( strpos($fileinfo->getFilename(),'.') === 0 )
                continue;

            if( strpos($fileinfo->getFilename(), '_large') !== false )
                continue;

            if( $fileinfo->isFile() ) {
                // create the product item under the current category
                $filename = $fileinfo->getFilename();

                if( ! preg_match( '/\.(png|jpg)$/i' , $filename ) ) {
                    $this->info( "skip file: $filename" , $level );
                    continue;
                }

                $parts = pathinfo( $fileinfo->getPathname() );
                $cImagePath      = $this->imageBase . DIRECTORY_SEPARATOR . md5_file( $fileinfo->getPathname() ) . '.' . $fileinfo->getExtension();
                $cLargeImagePath = $this->imageBase . DIRECTORY_SEPARATOR . md5_file( $fileinfo->getPathname() ) . '_large.' . $fileinfo->getExtension();

                $this->info( "copy:   $cImagePath" , $level );
                copy( $fileinfo->getPathname() , $cImagePath );

                $sLargeImagePath = $parts['dirname'] . '/' . $parts['filename'] . '_large.' . $parts['extension'];


                if( file_exists( $sLargeImagePath ) )  {
                    copy( $sLargeImagePath , $cLargeImagePath );
                    $this->info( "copy:   $cLargeImagePath" , $level );
                } else {
                    $this->info( "WARNING: $sLargeImagePath not found." );
                    // die( "$sLargeImagePath not found." );
                }

                // parse product name and sn name
                if( preg_match( '/(.*?)
                        \((.*?)\)
                        (.*?)\.
                        (jpg|png)
                        /xi', $filename , $regs ) ) 
                {
                    list( $orig, $name , $sn , $rest, $ext ) = $regs;
                    $name = trim($name);
                    $sn   = trim($sn);
                    $rest = trim($rest);
                    $this->info( "create product: $name -- $sn -- $rest " , $level );
                    $product = new \ProductBundle\Model\ProductBundle;
                    $product->loadOrCreate(array( 
                        'name' => $name, 
                        'thumb' => $cImagePath,  
                        'image' => $cLargeImagePath,
                        'sn' => $sn , 
                        'category_id' => $parent ? $parent->id : null ), array('name','sn'));
                    # $this->info( $product->lastSQL , $level );
                } 
                elseif ( preg_match( '/(.*)\.(jpg|png)$/i' , $filename, $regs ) ) {
                    list( $orig, $name , $ext ) = $regs;
                    $this->info( "create product: $name -- $sn" , $level );
                    $product = new \ProductBundle\Model\ProductBundle;
                    $product->loadOrCreate(array( 
                        'name' => $name, 
                        'thumb' => $cImagePath, 
                        'image' => $cLargeImagePath,
                        'category_id' => $parent ? $parent->id : null ),'name' );
                    # $this->info( $product->lastSQL , $level );
                }
                // throw new Exception( "Can not parse {$fileinfo->getPathname()}" );
            }
            elseif ($fileinfo->isDir() ) {
                // find sub-category
                # $this->info( "traverse category: " . $fileinfo->getFilename() , $level );

                // create category, with parent (if specified)
                $categoryName = $fileinfo->getFilename();
                $this->info("create category: $categoryName" , $level);

                $category = new Category;
                $category->loadOrCreate(array('name' => $categoryName, 'lang' => $lang, 'parent' => $parent ? $parent->id : 0 ) , 'name' );
                $this->traverse_category($lang,$fileinfo, $category->id ? $category: null ,$level+1); // pass parent category
            }
        }
    }

    function setWebroot($dir)
    {
        $this->webroot = $dir;
    }

    function import( $directory ) 
    {
        try {
            if( ! $this->imageBase )
                throw new Exception( "imageBase is not set." );
            if( ! file_exists($this->imageBase ) )
                mkdir( $this->imageBase , 0755 , true );

            $filenames = array();
            $iterator = new DirectoryIterator($directory);

            foreach ($iterator as $fileinfo) {
                if( $fileinfo->isDot() )
                    continue;

                /* top-level category is directory */
                if ($fileinfo->isDir()) 
                {
                    $currentLang = $fileinfo->getFilename();
                    $this->info("traverse language: $currentLang");
                    $this->traverse_category( $currentLang, $fileinfo );
                }
            }

            $this->info("rsync {$this->imageBase} => {$this->webroot}");
            system( "rsync -r {$this->imageBase}/ {$this->webroot}/{$this->imageBase}/" );

            $this->info("done");

        } catch ( Exception $e ) {
            $this->logger->info( print_r( $e , true ) );
            echo "Exception!! {$e->getMessage()} \n";
            echo "Log file: " . $this->logger->logFile . "\n";
        }

    }
}

