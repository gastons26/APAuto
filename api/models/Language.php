<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $code
 * @property string $display_name
 *
 * @property SimplePageLanguage[] $simplePageLanguages
 */
class Language extends \yii\db\ActiveRecord
{

    CONST NATIVE_VALUE = 'lv_LV';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 6],
            [['display_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'display_name' => 'Display Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimplePageLanguages()
    {
        return $this->hasMany(SimplePageLanguage::className(), ['language_id' => 'id']);
    }
}
