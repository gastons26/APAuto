<?php

use yii\db\Migration;

class m160807_215316_features extends Migration
{
    private $_car_table = <<<SQL
    CREATE TABLE IF NOT EXISTS `car` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `price` DECIMAL(15,2) NULL,
      `model` INT NOT NULL,
      `author` INT NOT NULL,
      `derive_date` DATETIME NULL,
      `created` DATETIME NULL,
      `deleted` DATETIME NULL,
      `sold` DATETIME NULL,
      PRIMARY KEY (`id`),
      INDEX `fk_cars_user1_idx` (`author` ASC),
      INDEX `fk_cars_models2_idx` (`model` ASC),
      CONSTRAINT `fk_cars_user1`
        FOREIGN KEY (`author`)
        REFERENCES `user` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_cars_models2`
        FOREIGN KEY (`model`)
        REFERENCES `models` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
SQL;

    private $_features_table = <<<SQL
      CREATE TABLE IF NOT EXISTS `feature` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `type` ENUM('DATE', 'CHBOX','DROPDOWN', 'TEXT') NULL COMMENT '\'DATE\'\n\'CHBOX\',\n\'DROPDOWN\',\n\'TEXT\'\n\'INPUT\'',
          `parent_id` INT NULL,
          `order_nr` INT NULL,
          PRIMARY KEY (`id`),
          INDEX `fk_feature_feature1_idx` (`parent_id` ASC),
          CONSTRAINT `fk_feature_feature1`
            FOREIGN KEY (`parent_id`)
            REFERENCES `feature` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
SQL;

    private $_feature_car_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `car_feature` (
          `car_id` INT NOT NULL,
          `feature_id` INT NOT NULL,
          INDEX `fk_car_has_feature_feature1_idx` (`feature_id` ASC),
          INDEX `fk_car_has_feature_car1_idx` (`car_id` ASC),
          CONSTRAINT `fk_car_has_feature_car1`
            FOREIGN KEY (`car_id`)
            REFERENCES `car` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_car_has_feature_feature1`
            FOREIGN KEY (`feature_id`)
            REFERENCES `feature` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
SQL;

    private $_feature_lang_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `feature_has_language` (
          `feature_id` INT NOT NULL,
          `language_id` INT NOT NULL,
          `value` TEXT NOT NULL,
          INDEX `fk_feature_has_language_language1_idx` (`language_id` ASC),
          INDEX `fk_feature_has_language_feature1_idx` (`feature_id` ASC),
          CONSTRAINT `fk_feature_has_language_feature1`
            FOREIGN KEY (`feature_id`)
            REFERENCES `feature` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_feature_has_language_language1`
            FOREIGN KEY (`language_id`)
            REFERENCES `language` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
SQL;


    public function up()
    {
        $this->execute($this->_car_table);
        $this->execute($this->_features_table);
        $this->execute($this->_feature_car_table);
        $this->execute($this->_feature_lang_table);
    }

    public function down()
    {

        return true;
    }
}
