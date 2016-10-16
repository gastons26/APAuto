<?php

namespace app\controllers;

use app\models\CarFeature;
use app\models\CarFeatureHasLanguage;
use app\models\Feature;
use app\models\FeatureEdit;
use app\models\Language;
use app\models\Models;
use Yii;
use app\models\Car;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
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
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        $cars = $this->getCarModels();
        $query = (($id!==null) ? Car::find()->joinWith(['modelObject'])->where('parent_model=:id', [':id'=>$id]) : Car::find());
        $query->with(['description', 'price', 'modelObject.parentModel']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', compact('dataProvider', 'cars'));
    }

    /**
     * Displays a single Car model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $car = new Car();

        if(Yii::$app->request->isPost) {
            $car->load(Yii::$app->request->post());

            if($car->save())
            {
                $this->saveAllFeatures($car, Yii::$app->request->post('FeatureEdit'));

                return $this->redirect(['pictures', 'id' => $car->id]);
            }
        }

        $features = FeatureEdit::getParentFeaturesForEdit();
        return $this->render('create', compact('car', 'features'));
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $car = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $car->load(Yii::$app->request->post());
            if($car->save()) {
                $car->unlinkAll('carFeatures', true);
                $this->saveAllFeatures($car, Yii::$app->request->post('FeatureEdit'));

                return $this->redirect(['pictures', 'id' => $car->id]);
            }
        } else {
            $features = FeatureEdit::getParentFeaturesForEdit();
            return $this->render('update', compact('car', 'features'));
        }
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $path = Yii::$app->basePath.Yii::$app->params['carImagePath'].$id;
        FileHelper::removeDirectory($path);

        return $this->redirect(['site/index']);
    }

    public function actionSold($id) {
        $car = Car::findOne($id);
        $car->sold = new Expression('NOW()');
        $car->save(false, ['sold']);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPictures($id) {
        $car = $this->findModel($id);
        return $this->render('pictures', compact('car'));
    }

    public function actionPictureUpload($id) {

        $imageFile = UploadedFile::getInstanceByName('car_images');
        $car = $this->findModel($id);

        $path = Yii::$app->basePath.Yii::$app->params['carImagePath'].$car->id;
        $url = Yii::$app->request->baseUrl.Yii::$app->params['carImageUrl'].$car->id;

        if (!is_dir($path)) {
            mkdir($path,0777,true);
            mkdir($path.'/thumbs',0777,true);
        }

        $num_files = 1;
        $files = array_filter(scandir($path), function($item) use ($path) {
            return (!is_dir($path.'/'.$item) && $item !=='..' && $item!=='.');
        });

        foreach($files as $file) {
            preg_match("/.(\d+)\./", $file, $matches);
            if(isset($matches[1]))
            {
                $num_files = ($num_files < $matches[1] ? $matches[1] : $num_files);
            }
        }

        if($imageFile) {
            $fileName = str_replace(' ', '_', $car->modelObject->parentModel->name.'_'.$car->modelObject->name).'_'.($num_files + 1).'.'.$imageFile->extension;
            $filePath = $path .'/'. $fileName;
            if ($imageFile->saveAs($filePath)) {

                $imageFile->tempName;

                Image::thumbnail($filePath, 200, 200)
                    ->resize(new Box(200,200))
                    ->save($path.'/thumbs/' . $fileName,
                        ['quality' => 65]);

                return Json::encode([
                    'files' => [[
                        'name' => $fileName,
                        'size' => $imageFile->size,
                        "url" => $url.'/'.$fileName,
                        "thumbnailUrl" => $url.'/thumbs/' . $fileName,
                        "deleteUrl" => Url::to(['picture-delete', 'id'=> $id, 'name'=> $fileName]),
                        "deleteType" => "POST"
                    ]]
                ]);
            }
        }

        $dir_files = [];

        foreach($files as $file) {
            if($file === '.' || $file === '..') {
                continue;
            }
            $dir_files[] = [
                'name' => $file,
                "url" => $url.'/'.$file,
                "thumbnailUrl" => $url.'/thumbs/' . $file,
                "deleteUrl" => Url::to(['picture-delete', 'id'=> $id, 'name'=> $file]),
                "deleteType" => "POST"
            ];
        }

        return Json::encode(['files' => $dir_files]);
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPictureDelete($id, $name)
    {

        $directory = Yii::$app->basePath.Yii::$app->params['carImagePath'].$id;

        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
            unlink($directory . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR. $name);
        }

        $files = FileHelper::findFiles($directory);
        $output = [];
        $url = Yii::$app->request->baseUrl.Yii::$app->params['carImageUrl'].$id;

        foreach ($files as $file){
            $path = $url . DIRECTORY_SEPARATOR . basename($file);
            $pathThumb = $url . DIRECTORY_SEPARATOR . 'thumbs'. DIRECTORY_SEPARATOR . basename($file);
            $output['files'][] = [
                'name' => basename($file),
                'size' => filesize($file),
                "url" => $path,
                "thumbnailUrl" => $pathThumb,
                "deleteUrl" => Url::to(['picture-delete', 'id'=> $id, 'name'=> basename($file)]),
                "deleteType" => "POST"
            ];
        }

        return Json::encode($output);
    }

    public function actionModels() {

        if(isset($_POST['depdrop_parents'])) {

            echo Json::encode(['output' => Models::getChildModelArray($_POST['depdrop_parents'][0]), 'selected' => '']);
            return;
        }

        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::find()->with(['carFeatures', 'modelObject', 'modelObject.parentModel'])->where('`car`.id=:id', [':id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getAllFeatures() {
        if (($model = Feature::find()->with(['features', 'mainLanguageFeature'])->where('parent_id IS NULL')->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function saveAllFeatures($car, $attrs) {
        foreach($attrs as $attr) {
            switch($attr['feature_type']) {
                case "DATE":
                case "TEXT_FIELD":
                case "PRICE":
                    $featureValue = new CarFeatureHasLanguage();
                    $featureValue->language_id = (isset($attr['language_id']) ? $attr['language_id'] : null);
                    $featureValue->value = $attr['feature_value'];

                    if($featureValue->value===null || trim($featureValue->value)==="")
                    {
                        continue;
                    }
                    $car->link('carFeatures', CarFeature::createModel($attr));

                    $featureValue->car_feature_id = (CarFeature::find()->where("car_id=:car_id AND feature_id=:feature_id", [':car_id'=>$car->id, ':feature_id' => $attr['feature_id']] )->one()->id);
                    $featureValue->save(false);
                    continue;
                    break;
                default:
                    $car->link('carFeatures', CarFeature::createModel($attr));
                    continue;
            }
        }
    }

    private function getCarModels() {
        return Models::find()->where('parent_model IS NULL')->all();
    }

}
