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
        $this->column('product_id')
            ->integer()
            ->label('產品')
            ->renderAs('SelectInput')
            ->refer('ProductBundle\\Model\\Product');

        $this->column('name')
            ->varchar(120)
            ->required()
            ->label(_('類型名稱'))
            ->renderAs('TextInput', [
              'size' => 20,
              'placeholder' => _('如: 綠色, 黑色, 羊毛, 大、中、小等等。'),
            ])
            ;

        $this->column('spec')
            ->text()
            ->label('規格說明')
            ->renderAs('TextInput')
            ->hint(_('在前台顯示的規格說明'))
            ;

        $this->column('comment')
            ->varchar(256)
            ->label(_('備註'))
            ;

    }

}
