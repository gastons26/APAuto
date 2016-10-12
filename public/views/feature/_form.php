<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="feature-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->parent_id === null): ?>
        <?= $form->field($model, 'type')->dropDownList([ 'DATE' => 'Datums', 'CHBOX' => 'Rūtiņu izvēle', 'DROPDOWN' => 'Izkrītošā izvēlne', 'TEXT' => 'Teksts', ]) ?>
    <?php endif; ?>
    
    <?php foreach($languages as $key => $lang) :?>
        <?= $form->field($featureLangModel, "[$key]value")->label('Valoda: '.$lang->display_name)->textInput(['value' => $model->getLangValue($lang)]); ?>
        <?= $form->field($featureLangModel, "[$key]language_id")->label(false)->hiddenInput(['value' => $lang->id]); ?>
    <?php endforeach; ?>

    <?= ($model->parent_id ? '' : $form->field($model, 'order_nr')->textInput()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Izveidot' : 'Labot', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
