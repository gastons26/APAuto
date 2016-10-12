<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Feature */

$this->title = $model->mainLanguageFeature->value;
?>
<div class="feature-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Labot', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Dzēst', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Vai tiešām vēlaties dzēst?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Tips</th>
            <td><?=$model->type;?></td>
        </tr>
        <tr>
            <th>Kārtas Nr.</th>
            <td><?=$model->order_nr;?></td>
        </tr>
        <?php foreach ($model->featureHasLanguages as $feature): ?>
            <tr>
                <th><?= $feature->language->display_name; ?></th>
                <td><?= $feature->value; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if(in_array($model->type, ['CHBOX', 'DROPDOWN'])): ?>
        <div class="feature-form">

            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <?php foreach($languages as $key => $lang) :?>
                    <div class="col-sm-4">
                        <?= $form->field($childLangModel, "[$key]value")->label('Valoda: '.$lang->display_name)->textInput(['value' => $childModel->getLangValue($lang)]); ?>
                        <?= $form->field($childLangModel, "[$key]language_id")->label(false)->hiddenInput(['value' => $lang->id]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Pievienot', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

        <table class="table table-striped table-bordered">
            <tr>
                <?php foreach($languages as $key => $lang) :?>
                    <th>Valuda: <?=$lang->display_name; ?></th>
                <?php endforeach; ?>
                <th>Darbības</th>
            </tr>


            <?php foreach ($childModels as $cFeature): ?>
                <tr>
                    <?php foreach ($cFeature->featureHasLanguages as $clFeature): ?>
                    <td><?=$clFeature->value;?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="<?=Url::to(['update', 'id'=>$cFeature->id])?>" title="Labot">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="<?=Url::to(['delete', 'id'=>$cFeature->id])?>" title="Dzēst" aria-label="Dzēst" data-confirm="Vai jūs esat pārliecināti, ka vēlaties nodzēst šo elementu?" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

