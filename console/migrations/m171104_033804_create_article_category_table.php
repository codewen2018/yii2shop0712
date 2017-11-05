<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m171104_033804_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment("分类名称"),
            'intro'=>$this->text()->notNull()->defaultValue("")->comment("简介"),
            'status'=>$this->smallInteger(1)->notNull()->defaultValue(1)->comment("状态"),
            'sort'=>$this->smallInteger(4)->notNull()->defaultValue(100)->comment('排序'),
            'is_help'=>$this->smallInteger(1)->notNull()->defaultValue(1)->comment("是否帮助")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
