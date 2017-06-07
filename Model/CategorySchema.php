<?php

namespace ProductBundle\Model;

use ProductBundle\Model\ProductBundle;
use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\CategoryCollection;
use Maghead\Schema\DeclareSchema;

use CommonBundle\Model\Mixin\MetaSchema;
use I18N\Model\Mixin\I18NSchema;

class CategorySchema extends DeclareSchema
{
    public function schema()
    {
        $this->table('product_categories');

        $this->column('name')
            ->varchar(130)
            ->label('產品類別名稱')
            ->required(1);

        $this->column('description')
            ->text()
            ->label('產品類別敘述')
            ->renderAs('TextareaInput', array(
                'class' => '+=mceEditor',
            ));

        $this->column('parent_id')
            ->integer()
            ->refer(CategorySchema::class)
            ->label(_('父類別'))
            ->integer()
            ->default(null)
            ->renderAs('SelectInput', array(
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

        $this->mixin(MetaSchema::class);
        $this->mixin(I18NSchema::class);

        $bundle = \ProductBundle\ProductBundle::getInstance();

        if ($bundle->config('ProductCategory.file')) {
            $this->many('files', CategoryFile::class, 'category_id', 'id');
        }
        if ($bundle->config('ProductCategory.subcategory')) {
            $this->many('subcategories', CategorySchema::class, 'parent_id', 'id');
            $this->belongsTo('parent', CategorySchema::class, 'id', 'parent_id');
        }

        if ($bundle->config('ProductCategory.multicategory')) {
            $this->many('category_products', ProductCategorySchema::class, 'category_id', 'id');
            $this->manyToMany('products', 'category_products', 'product');
        } else {
            $this->many('products', ProductSchema::class, 'category_id', 'id')->orderBy('created_on', 'ASC');
        }
    }
}
