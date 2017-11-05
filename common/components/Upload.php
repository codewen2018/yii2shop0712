<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/3
 * Time: 19:07
 * Company: 源码时代重庆校区
 */

namespace common\components;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Upload extends Model
{
    public $file;
    private $_appendRules;
    public function init ()
    {
        parent::init();
        $extensions = \Yii::$app->params['webuploader']['baseConfig']['accept']['extensions'];
        $this->_appendRules = [
            [['file'], 'file', 'extensions' => $extensions],
        ];
    }

    public function rules()
    {
        $baseRules = [];
        return array_merge($baseRules, $this->_appendRules);
    }

    public function upImage ()
    {
        //static 相当哪个类调用就代表哪个类
        $model = new static;

        $model->file = UploadedFile::getInstanceByName('file');


        if (!$model->file) {
            return false;
        }

        $relativePath = $successPath = '';
        if ($model->validate()) {
            $relativePath = \Yii::$app->params['imageUploadRelativePath'];
            $successPath = \Yii::$app->params['imageUploadSuccessPath'];
            $fileName = $model->file->baseName . '.' . $model->file->extension;
            if (!is_dir($relativePath)) {
                FileHelper::createDirectory($relativePath);
            }
            $model->file->saveAs($relativePath . $fileName);
            return [
                'code' => 0,
                'url' => \Yii::$app->params['domain'] . $successPath . $fileName,
                'attachment' => $successPath . $fileName
            ];
        } else {
            $errors = $model->errors;
            return [
                'code' => 1,
                'msg' => current($errors)[0]
            ];
        }
    }
}