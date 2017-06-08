<?php
namespace ProductBundle\Action;

use Phifty\FileUtils;
use ActionKit\RecordAction\UpdateRecordAction;
use ProductBundle\Model\Category;

class UpdateCategory extends UpdateRecordAction
{
    public $recordClass = Category::class;

    public $nested = true;

    /*
    public $relationships = array(
        'files' => array(
            'has_many' => true,
            'record' => 'ProductBundle\\Model\\CategoryFile',
            'self_key' => 'category_id',
            'foreign_key' => 'id',
        ),
    );
     */

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'upload';

        $this->replaceParam('image', 'Image')
            ->size($bundle->config('ProductCategory.image.size'))
            ->sizeLimit(($c=$bundle->config('ProductCategory.image.size_limit')) ? $c : 600)
            ->resizeWidth(($c = $bundle->config('ProductCategory.image.resize_width')) ?  $c : 800)
            ->renameFile(function ($name) {
                return FileUtils::filename_append_md5($name);
            })
            ->putIn($uploadDir);

        $this->replaceParam('thumb', 'Image')
            ->size($bundle->config('ProductCategory.thumb.size'))
            ->sizeLimit(($c=$bundle->config('ProductCategory.thumb.size_limit')) ? $c : 500)
            ->resizeWidth(($c = $bundle->config('ProductCategory.thumb.resize_width')) ? $c : 300)
            ->sourceField('image')
            ->renameFile(function ($name) {
                return FileUtils::filename_append_md5($name);
            })
            ->putIn('upload');
    }

    public function successMessage($ret)
    {
        return '產品類別更新成功。';
    }
}
