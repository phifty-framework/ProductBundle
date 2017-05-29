<?php
namespace ProductBundle\Model;
use Maghead\Schema\DeclareSchema;

class ProductTypeSchema extends DeclareSchema
{
    /* ProductType is like, Product Attribute 
     *
     * One Product can have blue, red, gray colors.
     **/
    public function schema()
    {
        $this->label('產品類型');

        $bundle = \ProductBundle\ProductBundle::getInstance();

        $this->column('product_id')
            ->integer()
            ->label('產品')
            ->renderAs('SelectInput')
            ->refer('ProductBundle\\Model\\ProductSchema');


        $this->column('name')
            ->varchar(120)
            ->required()
            ->label(_('名稱'))
            ->renderAs('TextInput', [
              'size' => 60,
              'placeholder' => _('如: 綠色, 黑色, 羊毛, 大、中、小等等。'),
            ])
            ;

        $this->column('icon')
            ->varchar(80)
            ->label( _('圖示') )
            ->renderAs('ThumbImageFileInput')
            ;

        if ($bundle->config('ProductType.quantity')) {
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

        $this->column('comment')
            ->text()
            ->label(_('備註'))
            ->renderAs('TextareaInput')
            ;

    }

}
