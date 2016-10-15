<?php
use yii\helpers\Html;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <div class="row">
        <div class="col-sm-1 hidden-xs">
            <h4>Markas</h4>
            <hr />
            <?= $this->render('_modelList', [
                'models' => $cars,
            ]) ?>
        </div>
        <div class="col-xs-12 col-sm-11">
            <div class="row">
                <div class="col-xs-6">
                    <h4>Informācija</h4>
                </div>
                <div class="col-xs-6">
                    <?= Html::a('Pievienot automašīnu', ['car/create'], [
                        'class' => 'btn btn-success pull-right',
                    ]) ?>
                </div>
            </div>
            <hr />
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_carView',
            ]); ?>
        </div>
    </div>
</div>

