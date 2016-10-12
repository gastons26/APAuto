<?php

use yii\helpers\Html;

$this->title = 'Labot īpašību: '
?>
<div class="feature-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'featureLangModel' => $featureLangModel
    ]) ?>

</div>
