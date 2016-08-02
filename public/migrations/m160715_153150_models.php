<?php

use yii\db\Migration;

class m160715_153150_models extends Migration
{
    private $_modelTable = <<<SQL
        CREATE TABLE IF NOT EXISTS `models` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parent_model` INT NULL,
  `icon` VARCHAR(128) NULL,
  `name` VARCHAR(45) NOT NULL,
  `deleted` DATETIME NULL,
  `changed` DATETIME NULL,
  `author` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_models_models1_idx` (`parent_model` ASC),
  INDEX `fk_models_user1_idx` (`author` ASC),
  CONSTRAINT `fk_models_models1`
    FOREIGN KEY (`parent_model`)
    REFERENCES `models` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_models_user1`
    FOREIGN KEY (`author`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
SQL;


    public function up()
    {
        $this->execute($this->_modelTable);
    }

    public function down()
    {
        $this->dropTable("models");

        return true;
    }
}
