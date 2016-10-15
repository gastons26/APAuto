<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car_feature".
 *
 * @property integer $car_id
 * @property integer $feature_id
 *
 * @property Car $car
 * @property Feature $feature
 */
class CarFeature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_feature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'feature_id'], 'required'],
            [['car_id', 'feature_id'], 'integer'],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => Car::className(), 'targetAttribute' => ['car_id' => 'id']],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'car_id' => Yii::t('models', 'Car ID'),
            'feature_id' => Yii::t('models', 'Feature ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
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
    public function getCarFeatureHasLanguages()
    {
        return $this->hasMany(CarFeatureHasLanguage::className(), ['car_feature_id' => 'id']);
    }

    public static function createModel($attrs) {

        $model = new self();
        $model->feature_id = $attrs['feature_id'];

        return $model;
    }
}
