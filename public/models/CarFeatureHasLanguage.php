<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car_feature_has_language".
 *
 * @property integer $car_feature_id
 * @property integer $language_id
 * @property string $value
 *
 * @property CarFeature $carFeature
 * @property Language $language
 */
class CarFeatureHasLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_feature_has_language';
    }

    public static function primaryKey() {
        return ['car_feature_id','language_id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_feature_id', 'value'], 'required'],
            [['car_feature_id', 'language_id'], 'integer'],
            [['value'], 'string'],
            [['car_feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarFeature::className(), 'targetAttribute' => ['car_feature_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'car_feature_id' => 'Car Feature ID',
            'language_id' => 'Language ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarFeature()
    {
        return $this->hasOne(CarFeature::className(), ['id' => 'car_feature_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @param $feature FeatureEdit
     * @return CarFeatureHasLanguage
     */
    public static function getFeatureValue($car, $feature)
    {
        $model = self::find()
                        ->joinWith('carFeature')
                        ->where(
                            [
                                'feature_id' => $feature->feature_id,
                                'language_id' => (!in_array($feature->feature_type, ['TEXT_FIELD']) ? null : $feature->language_id),
                                'car_id' => $car->id
                            ]
                        )
                ->one();

        return $model===null ? '' : $model->value;
    }
}
