<?php
use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;

$title = $car->modelObject->parentModel->name.' '.$car->modelObject->name;
?>

<div class="row">
    <div class="col-sm-5">
        <h4 style="float: left; padding-right: 10px"><?=$title?></h4>
        <?= Html::a('Atpakaļ', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
    </div>
</div>
<hr />


<?= FileUploadUI::widget([
    //'model' => $model,
    'name' => 'car_images',
    'url' => ['picture-upload', 'id' => $car->id],
    'gallery' => true,
    'load'=>true,
    'fieldOptions' => [
        'accept' => 'image/*'
    ],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ],

    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
        'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
    ],
]);
?>