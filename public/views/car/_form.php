<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use app\models\Models;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $car app\models\Car */
/* @var $form yii\widgets\ActiveForm */
/* @var $feature app\models\FeatureEdit */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{endWrapper}\n{error}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2 col-xl-1',
                'offset' => '',
                'wrapper' => 'col-sm-5 col-xl-7',
                'error' => 'col-sm-4 col-xl-3',
                'hint' => '',
            ]
        ]
    ]); ?>

    <div class="form-group field-car-date required">
        <label class="control-label col-sm-2 col-xl-1"><?=$car->getAttributeLabel('model'); ?></label>
        <div class="col-sm-5 col-xl-7">
            <div class="col-sm-6" style="padding-right: 20px;">
                <?php $car->parent_model =  ($car->isNewRecord ? null : $car->modelObject->parentModel->id); ?>
                <?= $form->field($car, 'parent_model', ['template'=>'{input}'])->label(false)->dropDownList(Models::getParentMappedArray(), ['id'=>'cat-id', 'prompt' => '--Auto marka--']); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($car, 'model', ['template'=>'{input}'])->label(false)->widget(DepDrop::classname(), [

                    'data' => (!$car->isNewRecord ? \yii\helpers\ArrayHelper::map(Models::find()->where('parent_model=:p_id', [':p_id'=>$car->parent_model])->all(), 'id', 'name') : []),

                    'options' => ['id'=>'subcat-id', 'value' => $car->model],
                    'pluginOptions'=>[
                        'depends'=>['cat-id'],
                        'placeholder' => 'Select...',
                        'url' => Url::to(['car/models'])
                    ]
                ]);?>
            </div>
        </div>
    </div>


    <div class="form-group field-car-date required">
        <label class="control-label col-sm-2 col-xl-1">Pieejams no</label>
        <div class="col-sm-4 col-lg-3">
            <?=DatePicker::widget([
                'model' => $car,
                'attribute' => 'derive_date',
                'options' => ['placeholder' => 'Datums..'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]); ?>
        </div>
    </div>


    <?php foreach($features as $key => $feature): ?>
        <?php
            switch($feature->feature_type) {
                case 'DATE':
                    echo $this->render('fields/_date', compact('form', 'feature', 'car', 'key'));
                    break;
                case 'CHBOX':
                    echo $this->render('fields/_checkbox', compact('form', 'feature', 'car', 'key'));
                    break;
                case 'DROPDOWN':
                    echo $this->render('fields/_dropdown', compact('form', 'feature', 'car', 'key'));
                    break;
                case 'TEXT_FIELD':
                    echo $this->render('fields/_text', compact('form', 'feature', 'car', 'key'));
                    break;
                case 'PRICE':
                    echo $this->render('fields/_price', compact('form', 'feature', 'car', 'key'));
                    break;
                default:
                    echo $this->render('fields/_input', compact('form', 'feature', 'car', 'key'));
            }
        ?>
    <?php endforeach; ?>


    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <?= Html::submitButton($car->isNewRecord ? 'Pievienot' : 'Labot', ['class' => $car->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
