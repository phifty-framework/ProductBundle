<?php

namespace ProductBundle;

use AdminUI\CRUDHandler;
use CRUD\CRUDReactHasManyEditor;
use ProductBundle\Model\ProductFile;

class ProductFileCRUDHandler extends CRUDHandler
{
    use CRUDReactHasManyEditor;

    public $modelClass = ProductFile::class;

    public $crudId     = 'product-file';

    public $templateId     = 'product_file';

    public $listColumns = ['id', 'title','file'];

    protected $searchQueryFields = ['product_id'];

    protected $applyRequestFields = ['product_id'];

    /**
     * itemDesc describes the relationship between data and the placeholder designed in the UI
     * and defines how the cover view should be built
     *
     * @return array
     */
    public function itemDesc()
    {
        $controls = [];
        if ($this->canCreate) {
            $controls[] = ['action' => 'create'];
        }
        if ($this->canUpdate) {
            $controls[] = ['action' => 'edit'];
        }
        if ($this->canDelete) {
            $controls[] = ['action' => 'delete'];
        }
        return [
            "view" => "TextCoverView",
            "display" => "block",
            "title" => [ "field" => "title" ],
            "subtitle" => ["format" => "備註: {remark}"],
            "desc" => [ "format" => "{file}" ],
            /*
            "footer" => [
                "columns" => [
                    [ "text" => [ 'format' => '數量 {quantity}' ] ],
                    [ "text" => [ 'format' => '價格 $ {price}' ] ]
                ]
            ],
            */
            "controls" => $controls,
        ];
    }
}

