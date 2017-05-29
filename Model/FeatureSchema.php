<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

class FeatureSchema extends DeclareSchema
{
    public $table = 'product_features';

    public function schema()
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $this->column('name')->varchar(128)->label('產品功能名稱');
        $this->column('description')->text()->label( _('Description') );
        $this->column('image')
            ->varchar(250)
            ->label( '產品功能圖示' );

        $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
    }
}


