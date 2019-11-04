<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\MessageTemplates */
/* @var $form yii\widgets\ActiveForm */
$Rights = Yii::$app->params['rights'];
$FormID = 41;
?>
<script src="<?php echo $baseUrl; ?>/ckeditor/ckeditor.js"></script>
<div class="productcategory-form">

    <?php $form = ActiveForm::begin(); ?>
	<table width="100%">
	<tr> 
		<td width="50%">
		<div class="form-group field-messagetemplates-code">
			<label class="control-label" for="messagetemplates-code">Code</label>
			<input disabled class="form-control" value="<?= $model->Code;?>" type="text">
			<div class="help-block"></div>
		</div>
		</td>
		<td>
			<div class="form-group field-messagetemplates-code">
				<label class="control-label" for="messagetemplates-code">Description</label>
				<input disabled class="form-control" value="<?= $model->Description;?>" type="text">
				<div class="help-block"></div>
			</div>
		</td>
    </tr>
	<tr> 
		<td><?= $form->field($model, 'Subject')->textInput() ?></td>
		<td></td>
    </tr>
	<tr> 
		<td colspan="2"><?= $form->field($model, 'Message')->textarea(['rows' => 6]) ?></td>
    </tr>
	</table>
    <div class="form-group">
        <?= ($Rights[$FormID]['Edit'] OR $Rights[$FormID]['Insert']) ? Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'bigbtn btn-success' : 'bigbtn btn-primary']) : ''?>
		<?= Html::a('Cancel', ['index'], ['class' => 'bigbtn btn-cancel']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
<script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	var editor = CKEDITOR.replace( 'MessageTemplates[Message]' );
</script>
