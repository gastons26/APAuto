<?php
use brussens\bootstrap\select\Widget as Select;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>

<h1>Līzings</h1><hr />

<?php if(Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>


<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
    <?= $form->field($page->language, 'code')->label(false)->widget(Select::className(), [
        'options' => [
            'onchange' => 'window.location = "?lang=" + $(this).val()',
            'options' => [
                'lv_LV' => ['data-icon'=>'flag-icon flag-icon-background flag-icon-lv'],
                'ru_RU' => ['data-icon'=>'flag-icon flag-icon-background flag-icon-ru'],
                'en_EN' => ['data-icon'=>'flag-icon flag-icon-background flag-icon-gb'],
            ],
            'encode'=>false
        ],
        'items' => ArrayHelper::map($languages, 'code', 'display_name')

    ]);
    ?>

    <?php  echo froala\froalaeditor\FroalaEditorWidget::widget([
        'model' => $page,
        'attribute' => 'content',
        'options'=>[// html attributes
            'id'=>'content'
        ],
        'clientOptions'=>[
            'toolbarInline'=> false,
            'theme' =>'royal',//optional: dark, red, gray, royal
            'language'=>'en_gb', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
            'imageUploadURL' => Url::to(['site/upload']),
            'imageUploadParam'=> 'editor_file',
            'height' => 400,
            'toolbarButtons' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
            'toolbarButtonsMD' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
            'toolbarButtonsSM' => ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],

        ]
    ]);
    ?>

    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Labot', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
    </div>

<?php ActiveForm::end();?>