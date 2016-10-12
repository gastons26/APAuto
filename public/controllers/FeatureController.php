<?php

namespace app\controllers;

use app\models\FeatureLanguage;
use app\models\Language;
use Yii;
use app\models\Feature;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FeatureController implements the CRUD actions for Feature model.
 */
class FeatureController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
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

    /**
     * Lists all Feature models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Feature::find()->with('mainLanguageFeature')->where('parent_id IS NULL'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feature model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $languages = $this->getLanguages();
        $childModel = new Feature();
        $childLangModel = new FeatureLanguage();

        $childModel->parent_id = $model->id;
        $childModel->type = $model->type;
        $childModel->order_nr = 1;
        if (Yii::$app->request->isPost && $childModel->save()) {
            foreach (Yii::$app->request->post()['FeatureLanguage'] as $data)
            {
                $fmodel = new FeatureLanguage();
                $fmodel->setAttributes($data);
                $fmodel->feature_id = $childModel->id;
                if(!$fmodel->save())
                {
                    throw new HttpException("Notikusi kļūda, saglabājot datus");
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            $childModels = $this->findChildModels($id);

            return $this->render('view', [
                'model' => $model,
                'languages' => $languages,
                'childModel' => $childModel,
                'childLangModel' => $childLangModel,
                'childModels' => $childModels
            ]);
        }
    }

    /**
     * Creates a new Feature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feature();
        $languages = $this->getLanguages();
        $featureLangModel = new FeatureLanguage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

                foreach (Yii::$app->request->post()['FeatureLanguage'] as $data)
                {
                    $fmodel = new FeatureLanguage();
                    $fmodel->setAttributes($data);
                    $fmodel->feature_id = $model->id;
                    if(!$fmodel->save())
                    {
                        throw new HttpException("Notikusi kļūda, saglabājot datus");
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'languages' => $languages,
                'featureLangModel' => $featureLangModel
            ]);
        }
    }

    /**
     * Updates an existing Feature model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $languages = $this->getLanguages();
        $featureLangModel = new FeatureLanguage();

        if (($model->load(Yii::$app->request->post()) || Yii::$app->request->isPost) && $model->save()) {
            FeatureLanguage::deleteAll('feature_id=:FID', [':FID'=>$model->id]);
            foreach (Yii::$app->request->post()['FeatureLanguage'] as $data)
            {
                $searchedValue = $data['language_id'];
                $lang = array_filter(
                    $languages,
                    function ($e) use (&$searchedValue) {
                        return $e->id == $searchedValue;
                    }
                );
                $lang = reset($lang);
                $model->link("languages", $lang, $data);
            }
            return $this->redirect(['view', 'id' => $model->parent_id !== null ? $model->parent_id : $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => $languages,
                'featureLangModel' => $featureLangModel
            ]);
        }
    }

    private function getLanguages()
    {
        return Language::find()->all();
    }

    /**
     * Deletes an existing Feature model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $parent = null;
        try{
            $model = $this->findModel($id);
            $parent = $model->parent_id;
            $model->delete();
        } catch (Exception $ex) {
            var_dump($ex);exit;
        }

        if($parent)
        {
            return $this->redirect(['view', 'id' => $parent]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Feature model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feature::find()->with('featureHasLanguages')->where('id=:ID', [':ID'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findChildModels($id)
    {
        return Feature::find()->where('parent_id=:PID', [':PID' => $id])->all();
    }

}
