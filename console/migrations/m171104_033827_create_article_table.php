<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171104_033827_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string('50')->notNull()->comment("名称"),
            'article_category_id'=>$this->integer()->notNull()->defaultValue(0)->comment("文章分类"),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->smallInteger(1)->notNull()->defaultValue(1)->comment("状态"),
            'sort'=>$this->smallInteger(4)->notNull()->defaultValue(100)->comment('排序'),
            'create_at'=>$this->integer()->notNull()->defaultValue(0)->comment("创建时间")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
