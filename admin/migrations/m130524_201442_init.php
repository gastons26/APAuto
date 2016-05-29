<?php

use yii\db\Migration;
class m130524_201442_init extends Migration
{


    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->execute('INSERT INTO `user`(`username`, `auth_key`, `password_hash`, `email`, `created_at`, `updated_at`)
                        VALUES ("apauto", "l2XHp2PtO7GxFrdrMhsMNWCd8h2XbvZQ", "$2y$13$zwUGmg2LsOCYooRXoK1D8.JWTBBqpvEKnT1Fk.uY3HzB2oI34PBPS", "apauto@inbox.lv", NOW(), NOW())');

    }
    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}