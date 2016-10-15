<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "models".
 *
 * @property integer $id
 * @property integer $parent_model
 * @property string $icon
 * @property string $name
 * @property string $deleted
 * @property string $changed
 * @property integer $author
 *
 * @property Models $parentModel
 * @property Models[] $models
 * @property User $author0
 */
class Models extends \yii\db\ActiveRecord
{
    private static $_path = "images/models/";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_model', 'author'], 'integer'],
            [['name', 'author'], 'required'],
            [['deleted', 'changed'], 'safe'],
            [['icon'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 1],
            [['name'], 'string', 'max' => 45],
            [['parent_model'], 'exist', 'skipOnError' => true, 'targetClass' => Models::className(), 'targetAttribute' => ['parent_model' => 'id']],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'parent_model' => Yii::t('models', 'parent_model'),
            'icon' => Yii::t('models', 'icon'),
            'name' => Yii::t('models', 'name'),
            'deleted' => Yii::t('models', 'deleted'),
            'changed' => Yii::t('models', 'changed'),
            'author' => Yii::t('models', 'author')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentModel()
    {
        return $this->hasOne(Models::className(), ['id' => 'parent_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        return $this->hasMany(Models::className(), ['parent_model' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    public static function getMarkModelItems()
    {
        return ArrayHelper::map(self::find()->where('parent_model IS NULL')->all(), 'id', 'name');
    }

    public function beforeValidate()
    {
        $date = new Expression('NOW()');

        $this->changed = $date;
        $this->author = Yii::$app->user->id;

        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        $filename = $this->icon ? $this->name . '.' . $this->icon->extension : $this->name.'.png';
        if($this->icon) {
            $this->icon->saveAs(self::$_path . $filename);
        }

        $this->icon = $filename;
        parent::afterValidate();
    }

    public function beforeSave($insert){
        return parent::beforeSave($insert);
    }

    public function getImageUrl() {
        return Yii::$app->getUrlManager()->baseUrl . "/" . self::$_path . $this->icon;
    }

    public static function getParentMappedArray() {
        return ArrayHelper::map(static::find()->where('parent_model IS NULL')->all(), 'id', 'name');
    }

    public static function getChildModelArray($id) {
        $models = static::find()->where('parent_model=:parent_id', [':parent_id' => $id])->all();
        $result = [];
        foreach($models as $model)
        {
            $result[] = ['id' => $model->id, 'name' => $model->name];
        }
        return $result;
    }
}
