<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Car */

$this->title = 'Labojam: ' . $car->modelObject->parentModel->name.' '.$car->modelObject->name;
?>
<div class="car-update">
    <div class="row">
        <h4 class="pull-left"><?= Html::encode($this->title) ?> </h4>
        <?= Html::a('Atpakaļ', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>

    </div>

    <hr style="margin-bottom: 10px;" />

    <?= $this->render('_form', compact('car','features')) ?>
</div>

