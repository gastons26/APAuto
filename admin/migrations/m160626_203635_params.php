<?php

use yii\db\Migration;

class m160626_203635_params extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS `params` (
                          `ID` INT NOT NULL AUTO_INCREMENT,
                          `alt_id` VARCHAR(45) NULL,
                          `value` TEXT NULL,
                          `author` INT NOT NULL,
                          PRIMARY KEY (`ID`),
                          INDEX `fk_params_user1_idx` (`author` ASC),
                          CONSTRAINT `fk_params_user1`
                            FOREIGN KEY (`author`)
                            REFERENCES `user` (`id`)
                            ON DELETE NO ACTION
                            ON UPDATE NO ACTION)");

        $this->execute("INSERT INTO `params` (`alt_id`, `value`, `author`) VALUES ('PHONE', '+371 29258219', 1)");
        $this->execute("INSERT INTO `params` (`alt_id`, `value`, `author`) VALUES ('MAIL', 'apauto@inbox.lv', 1)");
        $this->execute("INSERT INTO `params` (`alt_id`, `value`, `author`) VALUES ('ADRESS', 'Raiņa iela 88, Talsi, Talsu pilsēta, LV-3201', 1)");
    }

    public function down()
    {
        $this->dropTable("params");

        return true;
    }
}
