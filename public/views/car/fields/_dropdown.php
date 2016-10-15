<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $model app\models\Car */
/* @var $form yii\widgets\ActiveForm */
/* @var $feature app\models\FeatureEdit */

$selected_key = -1;
$dropdown_values = ArrayHelper::map($feature->getChilds(), 'id', 'mainLanguageFeature.value');

if(!$car->isNewRecord) {

    $car_features = ArrayHelper::map($car->carFeatures, 'feature_id', 'feature_id');

    foreach ($dropdown_values as $key => $value) {
        if (in_array($key, $car_features)) {
            $selected_key = $key;
            break;
        }
    }
}
?>

<?= $form->field($feature, "[$key]feature_id")
        ->label($feature->feature_label)
        ->dropDownList($dropdown_values, [
            'options' => [
                $selected_key => ['selected' => true]
            ]
        ]); ?>

<?=Html::activeHiddenInput($feature, "[$key]feature_type", ['value' => $feature->feature_type]);?>

