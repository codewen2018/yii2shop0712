<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */

class Brand extends \yii\db\ActiveRecord
{
    //状态文字
    public static $statusText=['-1'=>'删除','0'=>'隐藏','1'=>'显示'];
    //表单里的图片字段 不是数据库里字段
    public $imgFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 255],
            [['imgFile'],'file','extensions' => ['gif','jpg','png'],'skipOnEmpty' => true]
        //    [['logo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            //'logo' => '图片',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
}
