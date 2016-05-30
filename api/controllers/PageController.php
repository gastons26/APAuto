<?php

namespace app\controllers;

use app\models\SimplePage;
use app\models\SimplePageLanguage;
use Yii;
use yii\rest\ActiveController;
use yii\rest\Controller;


class PageController extends Controller
{
    public $modelClass = 'app\models\SimplePage';

    public function actionView($lang, $alt_id)
    {
        $page = SimplePageLanguage::find()->joinWith(['simplePage', 'language'])->where('alt_id=:ALT_ID AND code=:lang', [':ALT_ID' => $alt_id, ':lang'=>$lang])->one();

        echo json_encode(['content'=>$page->content]);
    }

    public function actionError()
    {
        echo 'Kļūda';
    }

}
