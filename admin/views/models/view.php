<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Models */

$this->title = $model->name;
?>
<div class="models-view">

    <h1>Marka: <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Labot', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Dzēst', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Vai tiešām vēlies dzēst?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'icon',
            'changed',
            'updater.username',
        ],
    ]) ?>

</div>

<div class="models-child-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($childModel, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Pievienot', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'parentModel.name',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>