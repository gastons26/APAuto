<?php

namespace app\controllers;

use app\models\Feature;
use app\models\Language;
use app\models\Models;
use app\models\SimplePage;
use app\models\SimplePageLanguage;
use app\models\User;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\LoginForm;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        if($action->id == 'upload')
        {
            return true;
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $cars = $this->getCarModels();
        $features = $this->getAllFeatures();


        return $this->render('index', compact('cars', 'features'));
    }

    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/empty';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact($lang=null)
    {

        $lang = ($lang === null ? Language::NATIVE_VALUE : $lang);
        $languages = $this->getLanguages();

        $page = SimplePageLanguage::find()->joinWith(['simplePage', 'language'])->where('alt_id=:ALT_ID AND code=:lang', [':ALT_ID' => SimplePage::CONTACT_PAGE, ':lang'=>$lang])->one();

        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            Yii::$app->session->setFlash('success', 'Dati veiksmīgi saglabāti');
        }

        return $this->render('contact', compact('page', 'languages'));
    }

    public function actionLeasing($lang=null)
    {
        $lang = ($lang === null ? Language::NATIVE_VALUE : $lang);
        $languages = $this->getLanguages();

        $page = SimplePageLanguage::find()->joinWith(['simplePage', 'language'])->where('alt_id=:ALT_ID AND code=:lang', [':ALT_ID' => SimplePage::LEASING_PAGE, ':lang'=>$lang])->one();

        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            Yii::$app->session->setFlash('success', 'Dati veiksmīgi saglabāti');
        }

        return $this->render('leasing', compact('page', 'languages'));
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionChangePassword()
    {
        $model = User::findOne(Yii::$app->user->id);

        if(Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->setPassword($model->password_hash);
                if($model->save()) {
                    Yii::$app->session->setFlash('success', 'Parole veiksmīgi nomainīta');
                }
            }
        }

        $model->password_hash = null;

        return $this->render('change_password', compact('model'));
    }

    public function actionUpload() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $imageFile = UploadedFile::getInstanceByName('editor_file');



        $path = Yii::$app->basePath.Yii::$app->params['editorImagePath'];
        $url = Yii::$app->request->baseUrl.Yii::$app->params['editorImageUrl'];

        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }

        if($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $imageFile->baseName.$uid.'.'.$imageFile->extension;
            $filePath = $path . $fileName;

            if ($imageFile->saveAs($filePath)) {
                return [
                    'link' => $url . $fileName
                ];
            }
        }
        throw new BadRequestHttpException("Neizdevās ielādēt bildi");
    }

    private function getLanguages($asArray=false)
    {
        return Language::find()->asArray($asArray)->all();
    }

    private function getCarModels() {
        return Models::find()->where('parent_model IS NULL')->all();
    }

    private function getAllFeatures() {
        return Feature::find()->where('parent_id IS NULL')->with('mainLanguageFeature')->all();
    }
}
