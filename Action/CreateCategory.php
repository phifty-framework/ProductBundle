<?php
namespace ProductBundle\Action;

use ActionKit;
use Phifty\FileUtils;
use ActionKit\RecordAction\CreateRecordAction;
use ProductBundle\Model\Category;
use ProductBundle\Model\CategoryFile;

class CreateCategory extends CreateRecordAction
{
    public $recordClass = Category::class;

    public $nested = true;

    public $relationships = array(
        'files' => array(
            'has_many' => true,
            'record' => CategoryFile::class,
            'self_key' => 'category_id',
            'foreign_key' => 'id',
        ),
    );

    public function schema()
    {
        $this->useRecordSchema();
        $bundle = \ProductBundle\ProductBundle::getInstance();
        $uploadDir = ($c=$bundle->config('upload_dir')) ? $c : 'upload';

        $this->replaceParam('image', 'Image')
            ->sizeLimit(($c=$bundle->config('ProductCategory.image.size_limit')) ? $c : 600)
            ->resizeWidth(($c = $bundle->config('ProductCategory.image.resize_width')) ?  $c : 800)
            ->renameFile(function ($name) {
                return FileUtils::filename_append_md5($name);
            })
            ->putIn($uploadDir);

        $this->replaceParam('thumb', 'Image')
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
        return _('新增成功');
    }
}
