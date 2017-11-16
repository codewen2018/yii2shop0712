<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m171116_012143_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment("用户名"),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment("状态"),
            'created_at' => $this->integer()->notNull()->comment("创建时间"),
            'updated_at' => $this->integer()->notNull()->comment("更新时间"),
            'last_login_ip'=>$this->integer()->comment("IP地址"),
            'last_login_time'=>$this->integer()->comment("最后登录时间"),
            'mobile'=>$this->string(20)->comment("手机")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
