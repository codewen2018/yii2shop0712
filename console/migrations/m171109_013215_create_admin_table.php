<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m171109_013215_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment("管理员"),
            'auth_key' => $this->string(32)->notNull()->comment("登录令牌"),
            'password_hash' => $this->string()->notNull()->comment("密码"),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment("状态"),
            'created_at' => $this->integer()->notNull()->comment("创建时间"),
            'updated_at' => $this->integer()->notNull()->comment("修改时间"),
            'last_login_at' => $this->integer()->notNull()->comment("登录时间"),
            'last_login_ip' => $this->string(15)->notNull()->comment("登录Ip"),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
