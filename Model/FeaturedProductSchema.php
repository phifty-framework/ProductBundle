<?php

namespace ProductBundle\Model;

use Maghead\Schema\DeclareSchema;

class FeaturedProductSchema extends DeclareSchema
{
    public function schema()
    {
        $this->column('name')
            ->varchar(128)
            ->label('產品名稱');

        $this->column('subtitle')
            ->varchar(128)
            ->label('產品名稱')
            ;

        $this->column('description')
            ->text()
            ->label('產品敘述');

        $this->column('cover_image')
            ->text()
            ->label('封面圖');
    }
}



