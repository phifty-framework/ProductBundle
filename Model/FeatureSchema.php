<?php
namespace ProductBundle\Model;
use LazyRecord\Schema\SchemaDeclare;

class FeatureSchema extends SchemaDeclare
{
    public $table = 'product_features';

    public function schema()
    {
        $plugin = \ProductBundle\ProductBundle::getInstance();
        $this->column('name')->varchar(128)->label('產品功能名稱');
        $this->column('description')->text()->label( _('Description') );
        $this->column('image')
            ->varchar(250)
            ->label( _('Product Feature Image') );

        if( $plugin->config('with_lang') ) {
            $this->mixin('I18N\\Model\\Mixin\\I18NSchema');
        }
    }
}


