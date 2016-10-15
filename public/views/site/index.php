<?php
use yii\helpers\Html;

$this->title = 'Automašīnas';
?>
<div class="site-index">

    <div class="body-content">

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
                <?= $this->render('_features', [
                    'features' => $features,
                ]) ?>
            </div>

        </div>

    </div>
</div>
