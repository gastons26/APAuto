<?php
namespace app\models;

/*
* @property integer $feature_id
* @property string $feature_label
* @property string $feature_type
 * @property string $feature_value
* @property integer $order_nr
* @property integer $language_id
 * @property string $langauge_name
*/
use Yii;
use yii\base\Model;

class FeatureEdit extends \yii\db\ActiveRecord
{

    public static function primaryKey() {
        return ['feature_id'];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['feature_id'], 'required'],
            [['feature_label', 'feature_type', 'feature_value', 'langauge_name'], 'string'],
            [['language_id', 'car_id', 'order_nr'], 'integer']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Lietotājvārds',
            'password' => 'Parole'
        ];
    }


    public static function getParentFeaturesForEdit()
    {
        return static::find()->orderBy(['`feature_edit`.order_nr' => SORT_ASC, '`feature_edit`.feature_id' => SORT_ASC])->all();
    }


    public function getChilds() {
        return Feature::find()->joinWith(['mainLanguageFeature'])->where('parent_id=:p_id', [':p_id' => $this->feature_id])->all();
    }
}
