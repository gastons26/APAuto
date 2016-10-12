<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Feature */

$this->title = 'Pievienot';
?>
<div class="feature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'featureLangModel' => $featureLangModel
    ]) ?>

</div>
