<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "me".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $parent_id
 */
class Me extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'me';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'parent_id' => 'Parent ID',
        ];
    }
}
