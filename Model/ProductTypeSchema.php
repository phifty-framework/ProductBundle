<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class ProductTypeSchema extends SchemaDeclare
{
    /* ProductType is like, Product Attribute 
     *
     * One Product can have blue, red, gray colors.
     **/
    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();

        $this->column('product_id')
            ->integer()
            ->label('產品')
            ->renderAs('SelectInput')
            ->refer('ProductBundle\\Model\\ProductSchema');

        $this->column('name')
            ->varchar(120)
            ->required()
            ->label(_('類型名稱'))
            ->renderAs('TextInput', [
              'size' => 20,
              'placeholder' => _('如: 綠色, 黑色, 羊毛, 大、中、小等等。'),
            ])
            ;

        if ( $bundle->config('with_type_quantity') ) {
            $this->column('quantity')
                ->integer()
                ->default(0)
                ->label( _('數量') )
                // ->renderAs('SelectInput')
                ->renderAs('TextInput')
                // ->hint(_('設定成 -1 時為不限制數量'))
                ->validValues(range(-1,100))
                ;
        }

        /*
        $this->column('spec')
            ->text()
            ->label('規格說明')
            ->renderAs('TextInput')
            ->hint(_('在前台顯示的規格說明'))
            ;
         */

        $this->column('comment')
            ->text()
            ->label(_('備註'))
            ->renderAs('TextareaInput')
            ;

    }

}
