<?php
namespace ProductBundle\Model;
use ProductBundle\Model\ProductBundle;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\CategoryCollection;
use LazyRecord\Schema\SchemaDeclare;

class CategorySchema extends SchemaDeclare
{
    public function schema()
    {
        $this->table('product_categories');

        $this->column( 'name' )
            ->varchar(130)
            ->label('Category Name')
            ->required(1);

        $this->column( 'description' )
            ->text()
            ->renderAs('TextareaInput',array(
                'class' => '+=mceEditor',
            ));

        $this->column( 'parent_id' )
            ->integer()
            ->refer( 'ProductBundle\\Model\\Category' )
            ->label( _('Parent Category') )
            ->integer()
            ->default(0)
            ->renderAs('SelectInput',array(
                'allow_empty' => 0,
            ));

        // hide this category in front-end
        $this->column('hide')
            ->boolean()
            ->label(_('Hide this category'));

        $this->column('thumb')
            ->varchar(128)
            ->label('縮圖')
            ;

        $this->column('image')
            ->varchar(128)
            ->label('圖片');

        $this->column('identity')
            ->varchar(32)
            ->label(_('Identity'));

        $this->mixin('Phifty\\Model\\Mixin\\MetadataSchema');
        $this->mixin('Phifty\\Model\\Mixin\\I18NSchema');

        $this->many('files','ProductBundle\\Model\\CategoryFile','category_id','id');
        $this->many('subcategories','ProductBundle\\Model\\CategorySchema','parent_id','id');
        $this->belongsTo('parent','ProductBundle\\Model\\CategorySchema','id','parent_id');

        $plugin = \ProductBundle\ProductBundle::getInstance();

        if ( $plugin->config('with_multicategory') ) {
            $this->many( 'category_products', 'ProductBundle\\Model\\ProductCategorySchema', 'category_id', 'id' );
            $this->manyToMany( 'products',   'category_products' , 'product');
        } else {
            $this->many('products','ProductBundle\\Model\\ProductSchema','category_id','id');
        }
    }

    public function bootstrap($record)
    {
        $record->create(array('identity' => 'c1', 'name' => 'Category 1','lang' => 'en'));
        $record->create(array('identity' => 'c2', 'name' => 'Category 2','lang' => 'en'));
        $record->create(array('identity' => 'c3', 'name' => 'Category 3','lang' => 'en'));

        $record->create(array('name' => '類別 1', 'lang'     => 'zh_TW'));
        $record->create(array('name' => '類別 2', 'lang'     => 'zh_TW'));
        $record->create(array('name' => '類別 3', 'lang'     => 'zh_TW'));
    }
}



