<?php

use yii\db\Migration;

class m161014_092313_FeatureEditView extends Migration
{

    private $_view_sql = <<<SQL
        CREATE VIEW `feature_edit` AS
    select
        `fhl`.`value` AS `feature_label`,
        `f`.`type` AS `feature_type`,
        `f`.`id` AS `feature_id`,
        `f`.`order_nr` AS `order_nr`,
        `l`.`id` AS `language_id`,
        `l`.`display_name` AS `langauge_name`,
        null as `feature_value`
    from
        ((`feature` `f`
        join `feature_has_language` `fhl` ON ((`f`.`id` = `fhl`.`feature_id`)))
        join `language` `l` ON (((`l`.`id` = `fhl`.`language_id`)
            and (`l`.`code` = 'lv_LV'))))
    where
        (isnull(`f`.`parent_id`)
            and (`f`.`type` <> 'TEXT_FIELD'))
    union select
        `fhl`.`value` AS `feature_label`,
        `f`.`type` AS `feature_type`,
        `f`.`id` AS `feature_id`,
        `f`.`order_nr` AS `order_nr`,
        `l`.`id` AS `language_id`,
        `l`.`display_name` AS `langauge_name`,
        null as `feature_value`
    from
        ((`feature` `f`
        join `feature_has_language` `fhl` ON ((`f`.`id` = `fhl`.`feature_id`)))
        join `language` `l` ON ((`l`.`id` = `fhl`.`language_id`)))
    where
        (isnull(`f`.`parent_id`)
            and (`f`.`type` = 'TEXT_FIELD'))
SQL;


    public function up()
    {
        $this->execute($this->_view_sql);
    }

    public function down()
    {
        $this->execute("DROP VIEW feature_edit");
        return true;
    }
}
