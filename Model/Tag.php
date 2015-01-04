<?php
/**
This is an auto-generated file,
Please DO NOT modify this file directly.
*/
namespace ProductBundle\Model;

use ProductBundle\Model\TagBase;

class Tag  extends TagBase {

    public function dataLabel()
    {
        return $this->name;
    }

    public function beforeCreate($args) {
        if (isset($args['name'])) {
            $tag = new self;
            $tag->load(array('name' => $args['name']));
            if ($tag->id) {
                return false;
            }
        }
        return $args;
    }

}

