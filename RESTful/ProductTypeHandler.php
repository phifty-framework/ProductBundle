<?php
namespace ProductBundle\RESTful;

use CRUD\Controller\RESTfulResourceController;

class ProductTypeHandler extends RESTfulResourceController
{
    public $recordClass = 'ProductBundle\\Model\\ProductType';
}
