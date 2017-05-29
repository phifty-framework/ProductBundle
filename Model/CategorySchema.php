<?php

namespace ProductBundle\Model;

use ProductBundle\Model\ProductBundle;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\CategoryCollection;
use Maghead\Schema\DeclareSchema;

class CategorySchema extends DeclareSchema
{
    public function schema()
    {
        $this->table('product_categories');

        $this->column( 'name' )
            ->varchar(130)
            ->label('產品類別名稱')
            ->required(1);

        $this->column( 'description' )
            ->text()
            ->label('產品類別敘述')
            ->renderAs('TextareaInput',array(
                'class' => '+=mceEditor',
            ));

        $this->column( 'parent_id' )
            ->integer()
            ->refer( 'ProductBundle\\Model\\CategorySchema' )
            ->label( _('父類別') )
            ->integer()
            ->default(NULL)
            ->renderAs('SelectInput',array(
                'allow_empty' => 0,
            ));

        // hide this category in front-end
        $this->column('hide')
            ->boolean()
            ->label(_('隱藏這個類別'));

        $this->column('thumb')
            ->varchar(128)
            ->label('縮圖')
            ;

        $this->column('image')
            ->varchar(128)
            ->label('圖片');

        $this->column('handle')
            ->varchar(32)
            ->label(_('程式用操作碼'));

        $this->mixin('CommonBundle\\Model\\Mixin\\MetaSchema');
        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');

        $bundle = \ProductBundle\ProductBundle::getInstance();

        if ($bundle->config('ProductCategory.file')) {
            $this->many('files','ProductBundle\\Model\\CategoryFile','category_id','id');
        }
        if ($bundle->config('ProductCategory.subcategory')) {
            $this->many('subcategories','ProductBundle\\Model\\CategorySchema','parent_id','id');
            $this->belongsTo('parent','ProductBundle\\Model\\CategorySchema','id','parent_id');
        }

        if ( $bundle->config('ProductCategory.multicategory') ) {
            $this->many( 'category_products', 'ProductBundle\\Model\\ProductCategorySchema', 'category_id', 'id' );
            $this->manyToMany( 'products',   'category_products' , 'product');
        } else {
            $this->many('products','ProductBundle\\Model\\ProductSchema','category_id','id')
                ->orderBy('created_on','ASC');
        }
    }
}
