<?php
namespace ProductBundle\Model;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\ProductTypeCollection;
use ProductBundle\Model\ProductImageCollection;
use ProductBundle\Model\ResourceCollection;
use LazyRecord\Schema\SchemaDeclare;

class ProductSchema extends SchemaDeclare
{
    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();

        $this->column('name')
            ->varchar(256)
            ->label('產品名稱')
            ->renderAs('TextInput',array( 'size' => 30 ))
            ;

        $this->column('subtitle')
            ->varchar(256)
            ->label('產品副標題')
            ->renderAs('TextInput',array( 'size' => 60 ))
            ;

        $this->column('sn')
            ->varchar(128)
            ->label('產品序號');

        $this->column('description')
            ->text()
            ->label('產品敘述');

        $this->column('content')
            ->text()
            ->label('產品內文')
            ->renderAs('TextareaInput');

        // spec_content
        $this->column('spec_content')
            ->text()
            ->label('產品規格')
            ->renderAs('TextareaInput')
            ;


        // image for zooming
        if( $bundle->config('zoom_image') ) {
            $this->column('zoom_image')
                ->varchar(128)
                ->label(_('產品放大圖'))
                ->renderAs('ThumbImageFileInput')
                ;
        }

        $this->column('category_id')
            ->refer('ProductBundle\\Model\\CategorySchema')
            ->integer()
            ->renderAs('+CRUD\\Widget\\QuickCRUDSelectInput',array(
                'record_class' => 'ProductBundle\\Model\\Category',
                'dialog_path' => '/bs/product_category/crud/quick_create',
                'allow_empty' => true,
            ))
            ->label(_('產品類別'));

        /* is a cover product ? show this product in some specific pages? */
        $this->column('is_cover')
            ->boolean()
            ->renderAs('CheckboxInput')
            ->label(_('封面產品'));

        $this->column('sellable')
            ->boolean()
            ->renderAs('SelectInput')
            ->default(true)
            ->validValues([
                _('可販售') => true,
                _('無法販售') => false,
            ])
            ->label( _('可販售') )
            ->hint( _('選擇可販售之後，請記得新增產品類別，前台才可以加到購物車。') )
            ;

        $this->column('orig_price')
            ->integer()
            ->label('產品原價')
            ->renderAs('TextInput',[  'placeholder' => _('如: 3200') ])
            ;

        $this->column('price')
            ->integer()
            ->label('產品售價')
            ->renderAs('TextInput',[  'placeholder' => _('如: 2800') ])
            ;

        $this->column('external_link')
            ->varchar(256)
            ->label('外部連結')
            ->renderAs('TextInput',array( 'size' => 70, 'placeholder' => _('如: http://....') ))
            ;

        /* private token, for private customers */
        $this->column('token')
            ->varchar(128)
            ->label( _('秘密編號') )
            ->desc( _('使用者必須透過這組秘密編號的網址才能看到這個產品。') );

        $this->column('hide')
            ->boolean()
            ->default(false)
            ->label(_('隱藏這個產品'))
            ->desc( _('目錄頁不要顯示這個產品，但是可以從網址列看到這個產品頁') );

        if ( $bundle->config('cover_image' ) ) {
            $this->column('cover_thumb')
                ->varchar(250)
                ->label('首頁封面圖')
                ->renderAs('ThumbImageFileInput');
            /*
            $this->column('cover_image')
                ->varchar(250)
                ->label('首頁封面圖')
                ->renderAs('ThumbImageFileInput');
             */
        }

        if( $bundle->config('spec_content_image') ) {
            $this->column('spec_image')
                ->varchar(250)
                ->label('規格主圖')
                ->renderAs('ThumbImageFileInput');

            $this->column('spec_thumb')
                ->varchar(250)
                ->label('規格縮圖')
                ->renderAs('ThumbImageFileInput');
        }

        $this->column('options_content')->text()->label('選配');

        if( kernel()->bundle('SEOPlugin') && $bundle->config('seo') ) {
            $this->mixin('SEOPlugin\\Model\\Mixin\\SEOSchema');
        }

        if( kernel()->bundle('StatusPlugin') ) {
            $this->mixin('StatusPlugin\\Model\\Mixin\\StatusSchema');
        }

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');

        $this->mixin('CommonBundle\\Model\\Mixin\\ImageSchema');
        $this->mixin('CommonBundle\\Model\\Mixin\\MetaSchema');

        $this->many( 'product_features', 'ProductBundle\\Model\\ProductFeatureSchema', 'product_id', 'id' );
        $this->manyToMany( 'features',   'product_features' , 'feature' );


        $this->many( 'product_products', 'ProductBundle\\Model\\ProductProductSchema', 'product_id', 'id' )
                ->order('ordering','ASC');

        $this->manyToMany( 'related_products',   'product_products' , 'related_product' );


        $this->many('images',     'ProductBundle\\Model\\ProductImageSchema' , 'product_id' , 'id' )
            ->order('ordering','ASC');

        $this->many('properties',     'ProductBundle\\Model\\ProductPropertySchema' , 'product_id' , 'id' )
            ->order('ordering','ASC');

            ;  # to product id => image product_id
        $this->many('types',      'ProductBundle\\Model\\ProductTypeSchema' , 'product_id' , 'id' );

        $this->many('resources',  'ProductBundle\\Model\\ResourceSchema' , 'product_id' , 'id' );  # to product id => image product_id
        $this->many('files',      'ProductBundle\\Model\\ProductFileSchema', 'product_id', 'id');

        if ( kernel()->bundle('RecipeBundle') ) {
            $this->many('product_recipes','ProductBundle\\Model\\ProductRecipeSchema','product_id','id');
            $this->manyToMany( 'recipes',   'product_recipes' , 'recipe' );
        }

        /*
        if ( $mixinClass = $bundle->config('product.mixin') ) {
            $this->mixin($mixinClass);
        }
        */
        if ( $bundle->config('subsections') ) {
            $this->many( 'subsections', 'ProductBundle\\Model\\ProductSubsectionSchema', 'product_id', 'id' )
                ->order('ordering','ASC')
                ->renderable(false);
        }
        if ( $bundle->config('links') ) {
            $this->many( 'links', 'ProductBundle\\Model\\ProductLinkSchema', 'product_id', 'id' )
                ->order('ordering','ASC')
                ->renderable(false);
        }
        if ( $bundle->config('usecases') ) {
            $this->many( 'product_usecases', 'ProductBundle\\Model\\ProductUseCaseSchema', 'product_id', 'id' )
                ->order('ordering','ASC')
                ->renderable(false);

            $this->manyToMany( 'usecases',   'product_usecases' , 'usecase' )
                ->filter(function($collection) {
                    $collection->order('lang','desc');
                    return $collection;
                });
        }

        if ( $bundle->config('multicategory') ) {
            $this->many( 'product_categories', 'ProductBundle\\Model\\ProductCategorySchema', 'product_id', 'id' )
                ->renderable(false);
            $this->manyToMany( 'categories',   'product_categories' , 'category' )
                ->filter(function($collection) {
                    $collection->order('lang','desc');
                    return $collection;
                });
        } else {
            $this->belongsTo( 'category' , 'ProductBundle\\Model\\CategorySchema','id','category_id');
        }
    }

    public function bootstrap($product) 
    {
        foreach( range(1,30) as $i ) {
            $ret = $product->create(array("name" => "Product $i" ));
            if ( !$ret->success) {
                echo $ret;
                die();
            }
        }
    }
}


