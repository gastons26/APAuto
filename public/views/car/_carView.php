<?php
 use yii\bootstrap\Html;
?>

<div class="row">
    <div class="col-sm-10" style="vertical-align: text-top;">
        <div class="pull-left" style="padding-right: 10px;">
            <?=Html::img($model->getFirstImage(), ['style'=>'width: 100px;']); ?>
        </div>
        <div>
            <label>Cena:</label> 123213 EUR
            <?=($model->sold!==null) ? '<span style="color:#ff0000; font-weight: bold;">PĀRDOTS</span>': ''?>
            <br />
            <label>Izveidots:</label> <?=$model->created;?>
            <hr />
        </div>
    </div>
    <div class="col-sm-2">
            <?= Html::a(' Labot', ['update', 'id' => $model->id], ['class' => 'glyphicon glyphicon-edit']) ?><br />
            <?= Html::a(' Bildes', ['pictures', 'id' => $model->id], ['class' => 'glyphicon glyphicon-picture']) ?><br />
            <?= Html::a(' Pārdots', ['sold', 'id' => $model->id], ['class' => 'glyphicon glyphicon-ok', 'style' => 'color: green; fond-size: bold;']) ?><br />
            <?= Html::a(' Dzēst', ['delete', 'id' => $model->id], [
                'class' => 'glyphicon glyphicon-remove',
                'style' => 'color: red',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
    </div>
</div>
<hr style="margin: 10px 0px;"/>