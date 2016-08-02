<?php

use yii\db\Migration;

class m160525_222059_simple_page extends Migration
{

    private $_simple_page_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `simple_page` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `alt_id` VARCHAR(10) NULL,
          PRIMARY KEY (`id`))
SQL;

    private $_simple_page_language_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `simple_page_language` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `simple_page_id` INT NOT NULL,
          `language_id` INT NOT NULL,
          `content` TEXT NOT NULL,
          `author` INT NOT NULL,
          INDEX `fk_simple_page_has_language_language1_idx` (`language_id` ASC),
          INDEX `fk_simple_page_has_language_simple_page1_idx` (`simple_page_id` ASC),
          INDEX `fk_simple_page_language_user1_idx` (`author` ASC),
          PRIMARY KEY (`id`),
          CONSTRAINT `fk_simple_page_has_language_simple_page1`
            FOREIGN KEY (`simple_page_id`)
            REFERENCES `simple_page` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_simple_page_has_language_language1`
            FOREIGN KEY (`language_id`)
            REFERENCES `language` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_simple_page_language_user1`
            FOREIGN KEY (`author`)
            REFERENCES `user` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
SQL;


    public function up()
    {
        $this->execute($this->_simple_page_table);

        $this->execute("INSERT INTO `simple_page` (`alt_id`) VALUES ('CONTACTS')");
        $this->execute("INSERT INTO `simple_page` (`alt_id`) VALUES ('LEASING')");

        $this->execute($this->_simple_page_language_table);

        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (1, 1, 'TRANSLATE_LV', 1)");
        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (1, 2, 'TRANSLATE_RU', 1)");
        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (1, 3, 'TRANSLATE_EN', 1)");

        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (2, 1, 'TRANSLATE_LV', 1)");
        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (2, 2, 'TRANSLATE_RU', 1)");
        $this->execute("INSERT INTO `simple_page_language` (`simple_page_id`, `language_id`, `content`, `author`) VALUES (2, 3, 'TRANSLATE_EN', 1)");
    }

    public function down()
    {
        echo "m160525_222059_simple_page cannot be reverted.\n";

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
