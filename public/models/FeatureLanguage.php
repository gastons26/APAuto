<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feature_has_language".
 *
 * @property integer $feature_id
 * @property integer $language_id
 * @property string $value
 *
 * @property Feature $feature
 * @property Language $language
 */
class FeatureLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feature_has_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feature_id', 'language_id', 'value'], 'required'],
            [['feature_id', 'language_id'], 'integer'],
            [['value'], 'string'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'feature_id' => Yii::t('models', 'Feature ID'),
            'language_id' => Yii::t('models', 'Language ID'),
            'value' => Yii::t('models', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Feature::className(), ['id' => 'feature_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
