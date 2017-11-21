<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property integer $order_info_id
 * @property integer $goods_id
 * @property integer $amount
 * @property string $goods_name
 * @property string $logo
 * @property string $price
 * @property string $total_price
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_info_id', 'goods_id', 'amount'], 'integer'],
            [['price', 'total_price'], 'number'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_info_id' => 'Order Info ID',
            'goods_id' => 'Goods ID',
            'amount' => 'Amount',
            'goods_name' => 'Goods Name',
            'logo' => 'Logo',
            'price' => 'Price',
            'total_price' => 'Total Price',
        ];
    }
}
