<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m171118_115834_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'amount' => $this->integer(),
            'member_id' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
