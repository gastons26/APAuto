<?php
    use kartik\date\DatePicker;
    use app\models\CarFeatureHasLanguage;
    use yii\widgets\ActiveForm;
    use yii\bootstrap\Html;
?>


<div class="form-group field-car-date required">
    <label class="control-label col-sm-2 col-xl-1"><?=$feature->feature_label; ?></label>

    <div class="col-sm-4 col-lg-3">
        <?=DatePicker::widget([
            'model' => $feature,
            'attribute' => "[$key]feature_value",
            'options' => [
                'placeholder' => 'Datums..',
                'value' => ($car->isNewRecord ? null : CarFeatureHasLanguage::getFeatureValue($car, $feature))
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy'
            ]
        ]); ?>
    </div>
</div>

<?=Html::activeHiddenInput($feature, "[$key]feature_id", ['value' => $feature->feature_id]);?>
<?=Html::activeHiddenInput($feature, "[$key]feature_type", ['value' => $feature->feature_type]);?>