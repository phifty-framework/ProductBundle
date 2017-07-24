<?php

namespace ProductBundle\Model;

use ProductBundle\Model\ProductCollection;
use ProductBundle\Model\CategoryCollection;
use ProductBundle\ProductBundle;
use Maghead\Schema\DeclareSchema;

use CommonBundle\Model\Mixin\MetaSchema;
use I18N\Model\Mixin\I18NSchema;

class CategorySchema extends DeclareSchema
{
    public function schema()
    {
        $bundle = ProductBundle::getInstance();

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


        // FIXME: when using foreign key, 0 is invalid because there is no such
        // record has the primary key 0
        $this->column('parent_id')
            ->integer()
            ->unsigned()
            ->refer(CategorySchema::class)
            ->label(_('父類別'))
            ->default(null)
            ->renderAs('SelectInput', [
                'allow_empty' => 0,
            ]);

        // hide this category in front-end
        $this->column('hide')
            ->boolean()
            ->label(_('隱藏這個類別'));

        $this->column('icon_image')
            ->varchar(128)
            ->label('圖示 Icon')
            ->contentType('ImageFile')
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config("upload_dir")) ? $c : "upload";
                $param->loadConfig($bundle->config("Category.{$param->name}"))
                    ->putIn($uploadDir)
                    ->renderAs("ThumbImageFileInput")
                    ;
            })
            ;

        $this->column('thumb')
            ->varchar(128)
            ->label('縮圖')
            ->contentType('ImageFile')
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config("upload_dir")) ? $c : "upload";
                $param->loadConfig($bundle->config("Category.{$param->name}"))
                    ->putIn($uploadDir)
                    ->renderAs("ThumbImageFileInput")
                    ;
            })
            ;

        $this->column('image')
            ->varchar(128)
            ->label('圖片')
            ->contentType('ImageFile')
            ->buildParam(function($param) {
                $bundle = \ProductBundle\ProductBundle::getInstance();
                $uploadDir = ($c = $bundle->config("upload_dir")) ? $c : "upload";
                $param->loadConfig($bundle->config("Category.{$param->name}"))
                    ->putIn($uploadDir)
                    ->renderAs("ThumbImageFileInput")
                    ;
            })
            ;

        $this->column('handle')
            ->varchar(32)
            ->label(_('程式用操作碼'));

        $this->mixin(MetaSchema::class);
        $this->mixin(I18NSchema::class);


        if ($bundle->config('Category.file')) {
            $this->many('files', CategoryFile::class, 'category_id', 'id');
        }

        if ($bundle->config('Category.subcategory')) {
            $this->many('subcategories', CategorySchema::class, 'parent_id', 'id');
            $this->belongsTo('parent', CategorySchema::class, 'id', 'parent_id');
        }

        if ($bundle->config('Category.multicategory')) {
            $this->many('category_products', ProductToCategorySchema::class, 'category_id', 'id');
            $this->manyToMany('products', 'category_products', 'product');
        } else {
            $this->many('products', ProductSchema::class, 'category_id', 'id')->orderBy('created_on', 'ASC');
        }
    }
}
