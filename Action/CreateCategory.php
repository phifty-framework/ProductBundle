<?php
namespace ProductBundle\Action;

use WebAction;
use Phifty\FileUtils;
use WebAction\RecordAction\CreateRecordAction;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryFile;

class CreateCategory extends CreateRecordAction
{
    public $recordClass = Category::class;

    public $nested = true;

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'upload';

        $this->replaceParam('image', 'Image')
            ->size($bundle->config('ProductCategory.image.size'))
            ->sizeLimit(($c = $bundle->config('ProductCategory.image.size_limit')) ? $c : 600)
            ->resizeWidth(($c = $bundle->config('ProductCategory.image.resize_width')) ?  $c : 800)
            ->renameFile(function ($name) {
                return FileUtils::filename_md5($name);
            })
            ->putIn($uploadDir);

        $this->replaceParam('thumb', 'Image')
            ->size($bundle->config('ProductCategory.thumb.size'))
            ->sizeLimit(($c=$bundle->config('ProductCategory.thumb.size_limit')) ? $c : 500)
            ->resizeWidth(($c = $bundle->config('ProductCategory.thumb.resize_width')) ? $c : 300)
            ->sourceField('image')
            ->renameFile(function ($name) {
                return FileUtils::filename_md5($name);
            })
            ->putIn('upload');
    }

    public function successMessage($ret)
    {
        return _('新增成功');
    }
}
