<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m171103_030716_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->comment("名称"),
            'intro'=>$this->string()->notNull()->defaultValue("")->comment("简介"),
            'logo'=>$this->string(100)->notNull()->comment("图片地址"),
            'sort'=>$this->smallInteger()->notNull()->defaultValue(100)->comment("排序"),
            'status'=>$this->smallInteger(1)->notNull()->defaultValue(1)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
