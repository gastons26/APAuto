<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simple_page_language".
 *
 * @property integer $simple_page_id
 * @property integer $language_id
 * @property string $content
 * @property integer $author
 *
 * @property SimplePage $simplePage
 * @property Language $language
 * @property User $author0
 */
class SimplePageLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simple_page_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['simple_page_id', 'language_id', 'author'], 'required'],
            [['simple_page_id', 'language_id', 'author'], 'integer'],
            [['content'], 'string'],
            [['simple_page_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimplePage::className(), 'targetAttribute' => ['simple_page_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'simple_page_id' => 'Simple Page ID',
            'language_id' => 'Language ID',
            'content' => 'Content',
            'author' => 'Author',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimplePage()
    {
        return $this->hasOne(SimplePage::className(), ['id' => 'simple_page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
}
