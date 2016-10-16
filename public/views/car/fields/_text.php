<?php
use brussens\bootstrap\select\Widget as Select;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use app\models\CarFeatureHasLanguage;
use yii\helpers\Url;


/* @var $car app\models\Car */
/* @var $feature app\models\FeatureEdit */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="form-group field-car-date required">
    <label class="control-label col-sm-2 col-xl-1"><?=$feature->feature_label.": ".$feature->langauge_name; ?></label>
    <div class="col-sm-10 col-xl-11">
        <?= froala\froalaeditor\FroalaEditorWidget::widget([
                'model' => $feature,
                'attribute' => "[$key]feature_value",
                'options'=>[// html attributes
                    'value' => ($car->isNewRecord ? null : CarFeatureHasLanguage::getFeatureValue($car, $feature)),
                    'id'=>'content_'.$feature->langauge_name
                ],
                'clientOptions'=>[
                    'toolbarInline'=> false,
                    'toolbarButtons' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|',
                                        'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR',  'undo', 'redo', 'clearFormatting'],
                    'toolbarButtonsMD' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|',
                                            'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR',  'undo', 'redo', 'clearFormatting'],
                    'toolbarButtonsSM' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|',
                                            'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR',  'undo', 'redo', 'clearFormatting'],
                    'imageUploadURL' => Url::to(['site/upload']),
                    'imageUploadParam'=> 'editor_file',
                    'theme' =>'royal',//optional: dark, red, gray, royal
                    'language'=>'lv', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
                    'height' => 200
                ]
            ]);
        ?>

        <?=Html::activeHiddenInput($feature, "[$key]feature_id", ['value' => $feature->feature_id]);?>
        <?=Html::activeHiddenInput($feature, "[$key]language_id", ['value' => $feature->language_id]);?>
        <?=Html::activeHiddenInput($feature, "[$key]feature_type", ['value' => $feature->feature_type]);?>

    </div>
</div>
