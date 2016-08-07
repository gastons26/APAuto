<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feature".
 *
 * @property integer $id
 * @property string $type
 * @property integer $parent_id
 * @property integer $order_nr
 *
 * @property CarFeature[] $carFeatures
 * @property Feature $parent
 * @property Feature[] $features
 * @property FeatureHasLanguage[] $featureHasLanguages
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['parent_id', 'order_nr'], 'integer'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'type' => Yii::t('models', 'Type'),
            'parent_id' => Yii::t('models', 'Parent ID'),
            'order_nr' => Yii::t('models', 'Order Nr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarFeatures()
    {
        return $this->hasMany(CarFeature::className(), ['feature_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Feature::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatures()
    {
        return $this->hasMany(Feature::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureHasLanguages()
    {
        return $this->hasMany(FeatureHasLanguage::className(), ['feature_id' => 'id']);
    }
}
