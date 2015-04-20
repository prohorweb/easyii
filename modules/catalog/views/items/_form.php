<?php
use yii\easyii\helpers\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;

$settings = $this->context->module->settings;
$module = $this->context->module->id;
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $form->field($model, 'title') ?>
<?php if($settings['itemThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= Image::thumb(Yii::getAlias('@webroot') . $model->image, 240) ?>">
        <a href="<?= Url::to(['/admin/'.$module.'/items/clear-image', 'id' => $model->primaryKey]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>
<?= $dataForm ?>
<?php if($settings['itemDescription']) : ?>
    <?= $form->field($model, 'description')->widget(Redactor::className(),[
        'options' => [
            'minHeight' => 400,
            'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'catalog'], true),
            'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'catalog'], true),
            'plugins' => ['fullscreen']
        ]
    ]) ?>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>