<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simple_page".
 *
 * @property integer $id
 * @property string $alt_id
 *
 * @property SimplePageLanguage[] $simplePageLanguages
 */
class SimplePage extends \yii\db\ActiveRecord
{
    CONST CONTACT_PAGE = 'CONTACTS';
    CONST LEASING_PAGE = 'LEASING';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simple_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alt_id'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alt_id' => 'Alt ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimplePageLanguages()
    {
        return $this->hasMany(SimplePageLanguage::className(), ['simple_page_id' => 'id']);
    }
}
