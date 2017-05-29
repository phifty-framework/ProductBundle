<?php
namespace ProductBundle\Model;

class CategoryCollection extends \ProductBundle\Model\CategoryCollectionBase
{
    public function containsCategoryByHandle($handle)
    {
        foreach ($this as $c) {
            if ($c->handle && $c->handle === $handle) {
                return true;
            }
            $pcs = $c->getAllParentCategories();
            foreach ($pcs as $pc) {
                if ($pc->handle && $pc->handle === $handle) {
                    return true;
                }
            }
        }
        return false;
    }
}
