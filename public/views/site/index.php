<?php

/*
 * @var $this yii\web\View
 * @var $cars app\models\Models
 */

$this->title = 'Automašīnas';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-2">
                <h2>Markas</h2>
                <hr />
                <?= $this->render('_modelList', [
                    'models' => $cars,
                ]) ?>
            </div>
            <div class="col-lg-10">
                <h2>Informācija</h2>
                <hr />
                <?= $this->render('_features', [
                    'features' => $features,
                ]) ?>
            </div>

        </div>

    </div>
</div>
