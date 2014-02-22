<?php
namespace ProductBundle\Action;
use ActionKit;
use Phifty\FileUtils;
use ActionKit\RecordAction\CreateRecordAction;

class CreateProductSubsection extends CreateRecordAction
{
    public $recordClass = 'ProductBundle\\Model\\ProductSubsection';

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = kernel()->bundle('ProductBundle');

        $imageSize = $bundle->config('ProductSection.cover_image.size');
        $imageSizeLimit = $bundle->config('ProductSection.cover_image.size_limit');
        $imageResizeWidth = $bundle->config('ProductSection.cover_image.resize_width') ?: 0;

        $uploadDir = $bundle->config('upload_dir') ?: 'upload';

        $this->param('cover_image','Image')
            ->sizeLimit( $imageSizeLimit )
            ->size( $imageSize )
            ->required()
            ->hint( $bundle->config('ProductSubsection.image.hint') )
            ->hintFromSizeInfo()
            ->prefix('/')
            ->label('主圖')
            ;

    }


    public function successMessage($ret) 
    {
        return '產品子區塊新增成功';
    }
}



