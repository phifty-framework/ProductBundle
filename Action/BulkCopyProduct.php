<?php
namespace ProductBundle\Action;
use ActionKit\RecordAction\BulkCopyRecordAction;

class BulkCopyProduct extends BulkCopyRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\Product';

    public $newFields = array('lang', 'category_id');

    public function afterCopy($record, $data, $newRecord) 
    {
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $newCategory = $this->arg('category_id');
        if ( $newCategory && $bundle->config('ProductCategory.multicategory') ) {
            $pc = new \ProductBundle\Model\ProductCategory;
            $pc->create(array(
                'category_id' => $newCategory,
                'product_id' => $newRecord->id,
            ));
        }

        if ( isset($record->images) ) {
            $images = $record->images;
            $images->fetch();
            foreach( $images as $image ) {
                $imageArgs = $image->getData();
                unset($imageArgs['id']);
                $imageArgs['product_id'] = $newRecord->id;
                $newImage = new \ProductBundle\Model\ProductImage;
                $ret = $newImage->create($imageArgs);
                if ( ! $ret->success ) {
                    return $this->error('產品圖片複製錯誤');
                }
            }
        }

        if ( isset($record->resources) ) {
            $resources = $record->resources;
            $resources->fetch();
            foreach( $resources as $resource ) {
                $resourceArgs = $resource->getData();
                unset($resourceArgs['id']);
                $resourceArgs['product_id'] = $newRecord->id;
                $newResource = new \ProductBundle\Model\Resource;
                $ret = $newResource->create($resourceArgs);
                if ( ! $ret->success ) {
                    return $this->error('產品資源複製錯誤');
                }
            }
        }

        if ( isset($record->subsections) ) {
            $subsections = $record->subsections;
            $subsections->fetch();
            foreach( $subsections as $subsection ) {
                $subsectionArgs = $subsection->getData();
                unset($subsectionArgs['id']);
                $subsectionArgs['product_id'] = $newRecord->id;
                $newRecord = new \ProductBundle\Model\ProductSubsection;
                $ret = $newRecord->create($subsectionArgs);
                if ( ! $ret->success ) {
                    return $this->error('產品資源複製錯誤');
                }
            }
        }

    }
}

