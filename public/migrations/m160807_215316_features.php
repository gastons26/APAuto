<?php

use yii\db\Migration;

class m160807_215316_features extends Migration
{
    private $_car_table = <<<SQL
    CREATE TABLE IF NOT EXISTS `car` (
      `id` INT NOT NULL AUTO_INCREMENT,
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
          CREATE TABLE IF NOT EXISTS `ap_auto`.`feature` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `type` ENUM('DATE', 'CHBOX','DROPDOWN', 'NUMBER','PRICE', 'TEXT_FIELD'),
              `parent_id` INT NULL,
              `order_nr` INT NULL,
              `can_delete` TINYINT(1) NULL DEFAULT true,
              PRIMARY KEY (`id`),
              INDEX `fk_feature_feature1_idx` (`parent_id` ASC),
              CONSTRAINT `fk_feature_feature1`
                FOREIGN KEY (`parent_id`)
                REFERENCES `ap_auto`.`feature` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
SQL;

    private $_feature_car_table = <<<SQL
        CREATE TABLE IF NOT EXISTS `ap_auto`.`car_feature` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `car_id` INT NOT NULL,
          `feature_id` INT NOT NULL,
          INDEX `fk_car_has_feature_feature1_idx` (`feature_id` ASC),
          INDEX `fk_car_has_feature_car1_idx` (`car_id` ASC),
          PRIMARY KEY (`id`),
          CONSTRAINT `fk_car_has_feature_car1`
            FOREIGN KEY (`car_id`)
            REFERENCES `ap_auto`.`car` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `fk_car_has_feature_feature1`
            FOREIGN KEY (`feature_id`)
            REFERENCES `ap_auto`.`feature` (`id`)
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
            ON DELETE CASCADE 
            ON UPDATE CASCADE ,
          CONSTRAINT `fk_feature_has_language_language1`
            FOREIGN KEY (`language_id`)
            REFERENCES `language` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION )
SQL;

    private $_car_feature_has_language = <<<SQL
        CREATE TABLE IF NOT EXISTS `ap_auto`.`car_feature_has_language` (
          `car_feature_id` INT NOT NULL,
          `language_id` INT NULL,
          `value` TEXT NOT NULL,
          INDEX `fk_car_feature_has_language_language2_idx` (`language_id` ASC),
          INDEX `fk_car_feature_has_language_car_feature2_idx` (`car_feature_id` ASC),
          CONSTRAINT `fk_car_feature_has_language_car_feature2`
            FOREIGN KEY (`car_feature_id`)
            REFERENCES `ap_auto`.`car_feature` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
          CONSTRAINT `fk_car_feature_has_language_language2`
            FOREIGN KEY (`language_id`)
            REFERENCES `ap_auto`.`language` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
SQL;

    private $_insert_default_fields = <<<SQL
    INSERT INTO `feature` (`id`, `type`, `parent_id`, `order_nr`, `can_delete`) VALUES
      (1, 'TEXT_FIELD', NULL, 999, 0),
      (2, 'PRICE', NULL, 1, 0);
SQL;

    private $_insert_default_feature_langs = <<<SQL
        INSERT INTO `feature_has_language` (`feature_id`, `language_id`, `value`) VALUES
            (1, 1, 'Apraksts'),
            (1, 2, 'Oписание'),
            (1, 3, 'Description'),
            (2, 1, 'Cena'),
            (2, 2, 'Цена'),
            (2, 3, 'Price');
SQL;





    public function up()
    {
        $this->execute($this->_car_table);
        $this->execute($this->_features_table);
        $this->execute($this->_feature_car_table);
        $this->execute($this->_feature_lang_table);
        $this->execute($this->_car_feature_has_language);
        $this->execute($this->_insert_default_fields);
        $this->execute($this->_insert_default_feature_langs);
    }

    public function down()
    {

        $this->dropTable('feature_has_language');
        $this->dropTable('car_feature_has_language');
        $this->dropTable('car_feature');
        $this->dropTable('feature');
        $this->dropTable('car');
        return true;
    }
}
