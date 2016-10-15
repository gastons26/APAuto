<?php

namespace app\models;

use Yii;
use yii\console\Exception;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "car".
 *
 * @property integer $id
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

    public $parent_model;

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
            'model' => Yii::t('models', 'Model'),
            'author' => Yii::t('models', 'Author'),
            'derive_date' => Yii::t('models', 'DeriveDate'),
            'created' => Yii::t('models', 'Created'),
            'deleted' => Yii::t('models', 'Deleted'),
            'sold' => Yii::t('models', 'Sold'),
        ];
    }

    public function beforeValidate() {
        $this->author = Yii::$app->user->id;
        $this->created = new Expression('NOW()');
        $this->derive_date = date("Y-m-d", strtotime($this->derive_date));

        return parent::beforeValidate();
    }

    public function afterFind() {
        $this->derive_date = date("d.m.Y", strtotime($this->derive_date));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorObject()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelObject()
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

    public function getFirstImage() {

        $path = Yii::$app->basePath.Yii::$app->params['carImagePath']. $this->id. DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR;
        $url = Yii::$app->request->baseUrl.Yii::$app->params['carImageUrl'];

        if (!is_dir($path)) {
            return $url.Yii::$app->params['default_car_image'];
        }

        $files = FileHelper::findFiles($path);

        if(isset($files[0]))
        {
            return $url. $this->id. DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR . basename($files[0]);
        }
        return $url.Yii::$app->params['default_car_image'];
    }

}
