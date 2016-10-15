<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Car */

$this->title = $model->modelObject->parentModel->name.' '.$model->modelObject->name;
?>
<div class="car-view">

    <h4>Automašīna: <?= Html::encode($this->title) ?></h4><hr /><br />

    <p>
        <?= Html::a('Labot', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Pievienot bildes', ['pictures', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Dzēst', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'model',
            'author',
            'derive_date',
            'created'
        ],
    ]) ?>

</div>
