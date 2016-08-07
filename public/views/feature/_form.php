<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="feature-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'DATE' => 'Datums', 'CHBOX' => 'Rūtiņu izvēle', 'DROPDOWN' => 'Izkrītošā izvēlne', 'TEXT' => 'Teksts', ]) ?>

    <?= ($model->parent_id ? '' : $form->field($model, 'order_nr')->textInput()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Izveidot' : 'Labot', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
