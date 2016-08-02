<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

?>

<h1>Mainīt paroli</h1><hr />

<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

    <?= $form->field($model, 'password_hash')->textInput(); ?>

    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Mainīt', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
    </div>

<?php ActiveForm::end();?>
