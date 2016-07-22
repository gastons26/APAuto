<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="models-index">

    <h1>Automašīnu marku saraksts</h1>

    <p>
        <?= Html::a('Pievienot jaunu marku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_model',
            'icon',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
