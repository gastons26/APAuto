<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Car */

$this->title = 'Pievienot jaunu automašīnu';
?>
<div class="car-create">
    <h4><?= Html::encode($this->title) ?></h4><hr />
    <br />
    <?= $this->render('_form', compact('car','features')) ?>
</div>
