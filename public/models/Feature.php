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
 * @property boolean $can_delete
 *
 * @property CarFeature[] $carFeatures
 * @property Feature $parent
 * @property Feature[] $features
 * @property FeatureHasLanguage[] $featureHasLanguages
 */
class Feature extends \yii\db\ActiveRecord
{

    CONST DESCRIPTION = 1;
    CONST PRICE = 2;

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
            [['parent_id', 'order_nr', 'can_delete'], 'integer'],
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
            'parent_id' => Yii::t('models', 'ParentID'),
            'order_nr' => Yii::t('models', 'OrderNr'),
        ];
    }

    /**
     * @param $lang Language
     */
    public function getLangValue($lang)
    {
        if($this->featureHasLanguages==null)
        {
            return null;
        }

        $model = array_filter(
            $this->featureHasLanguages,
            function ($e) use (&$lang) {
                return $e->language_id == $lang->id;
            }
        );
        $model = reset($model);
        return isset($model) && $model->value ? $model->value : null;
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
        return $this->hasMany(FeatureLanguage::className(), ['feature_id' => 'id']);
    }

    public function getMainLanguageFeature()
    {
        return $this->hasOne(FeatureLanguage::className(), ['feature_id' => 'id'])->where('`feature_has_language`.language_id=:langId', [':langId'=>1]);
    }

    public function getLanguages() {
        return $this->hasMany(Language::className(), ['id' => 'language_id'])
            ->viaTable(FeatureLanguage::tableName(), ['feature_id' => 'id']);
    }

    public function getMainLanguage() {
        return $this->hasOne(Language::className(), ['id' => 'language_id'])
            ->viaTable(FeatureLanguage::tableName(), ['feature_id' => 'id'])->where('code=:code', [':code'=>'lv_LV']);
    }

    public static function fieldTypes() {
        return [ 'DATE' => 'Datums', 'CHBOX' => 'Rūtiņu izvēle', 'DROPDOWN' => 'Izkrītošā izvēlne', 'TEXT_FIELD' => 'Teksts', 'PRICE' => 'Cena'];
    }
}
