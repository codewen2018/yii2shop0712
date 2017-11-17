<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $address
 * @property string $mobile
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'status'], 'integer'],
            [['name', 'province', 'city', 'county', 'mobile'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户ID',
            'name' => '姓名',
            'province' => '省份',
            'city' => '市',
            'county' => '区县',
            'address' => '地址',
            'mobile' => '手机号',
            'status' => '状态:1 默认 0非默认',
        ];
    }
}
