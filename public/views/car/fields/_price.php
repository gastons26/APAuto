<?php
use yii\bootstrap\Html;
use app\models\CarFeatureHasLanguage;

/* @var $car app\models\Car */
/* @var $form yii\widgets\ActiveForm */
/* @var $feature app\models\Feature */
?>

<?= $form->field($feature, "[$key]feature_value")
    ->label($feature->feature_label.' (EUR)')
    ->textInput(['value' => $car->isNewRecord ? null : CarFeatureHasLanguage::getFeatureValue($car, $feature)]);
?>

<?=Html::activeHiddenInput($feature, "[$key]feature_id", ['value' => $feature->feature_id]);?>
<?=Html::activeHiddenInput($feature, "[$key]feature_type", ['value' => $feature->feature_type]);?>