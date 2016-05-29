<?php

use yii\db\Migration;

class m160525_201240_language extends Migration
{
    private $_lang_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `language` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `code` VARCHAR(6) NULL,
          `display_name` VARCHAR(45) NULL,
          PRIMARY KEY (`id`))
SQL;


    public function up()
    {
        $this->execute($this->_lang_table);
        $this->execute("INSERT INTO `language` (`code`, `display_name`) VALUES ('lv_LV', 'Latviešu')");
        $this->execute("INSERT INTO `language` (`code`, `display_name`) VALUES ('ru_RU', 'Русский')");
        $this->execute("INSERT INTO `language` (`code`, `display_name`) VALUES ('en_EN', 'English')");

    }

    public function down()
    {
        echo "m160525_201240_language cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
