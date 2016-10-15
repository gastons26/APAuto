<?php
    use yii\helpers\Url;
?>

<?php foreach ($models as $model): ?>
    <div class="pull-left" style="margin-right: 5px;">
        <a href="<?=Url::to(['index', 'id'=>$model->id]);?>">
            <img src="<?=$model->getImageUrl();?>" />
        </a>
    </div>
<?php endforeach; ?>
