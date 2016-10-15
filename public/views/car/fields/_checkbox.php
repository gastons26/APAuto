<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/* @var $model app\models\Car */
/* @var $form yii\widgets\ActiveForm */
/* @var $feature app\models\FeatureEdit */

$values = ArrayHelper::map($feature->getChilds(), 'id', 'mainLanguageFeature.value');
$features = ArrayHelper::map($car->carFeatures, 'feature_id', 'feature_id');

?>

<?= $form->field($feature, "[$key]feature_id")
    ->label($feature->feature_label)
    ->checkboxList($values,
        [
            'item' => function($index, $label, $name, $checked, $value) use ($features) {
                $checked = in_array($value, $features);

                $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                return Html::label($checkbox . $label, null, ['class' => 'checkbox-inline']);

            }
        ]
    ) ?>

<?=Html::activeHiddenInput($feature, "[$key]feature_type", ['value' => $feature->feature_type]);?>
