<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car".
 *
 * @property integer $id
 * @property string $price
 * @property integer $model
 * @property integer $author
 * @property string $derive_date
 * @property string $created
 * @property string $deleted
 * @property string $sold
 *
 * @property User $author0
 * @property Models $model0
 * @property CarFeature[] $carFeatures
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['model', 'author'], 'required'],
            [['model', 'author'], 'integer'],
            [['derive_date', 'created', 'deleted', 'sold'], 'safe'],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
            [['model'], 'exist', 'skipOnError' => true, 'targetClass' => Models::className(), 'targetAttribute' => ['model' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'price' => Yii::t('models', 'Price'),
            'model' => Yii::t('models', 'Model'),
            'author' => Yii::t('models', 'Author'),
            'derive_date' => Yii::t('models', 'Derive Date'),
            'created' => Yii::t('models', 'Created'),
            'deleted' => Yii::t('models', 'Deleted'),
            'sold' => Yii::t('models', 'Sold'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel0()
    {
        return $this->hasOne(Models::className(), ['id' => 'model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarFeatures()
    {
        return $this->hasMany(CarFeature::className(), ['car_id' => 'id']);
    }
}
