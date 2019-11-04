<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */

$Rights = Yii::$app->params['rights'];
$FormID = 16;
?>

<div class="default-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<table width="100%">
	<tr> 
		<td width="50%"><?= $form->field($model, 'CompanyName')->textInput() ?></td>
		<td></td>
    </tr>
	<tr> 
		<td><?= $form->field($model, 'PostalAddress')->textInput() ?></td>
		<td><?= $form->field($model, 'PostalCode')->textInput() ?></td>
    </tr>	
	<tr> 
		<td><?= $form->field($model, 'Town')->textInput() ?></td>
		<td><?= $form->field($model, 'CountryID')->dropDownList($country,['prompt'=>'Select...']) ?></td>
    </tr>
	<tr> 
		<td><?= $form->field($model, 'Telephone')->textInput() ?></td>
		<td><?= $form->field($model, 'Mobile')->textInput() ?></td>
    </tr>
	<tr> 
		<td><?= $form->field($model, 'Fax')->textInput() ?></td>
		<td><?= $form->field($model, 'Email')->textInput() ?></td>
    </tr>	
	<tr> 
		<td><?= $form->field($model, 'PIN')->textInput() ?></td>
		<td><?= $form->field($model, 'VATNo')->textInput() ?></td>
    </tr>
	<tr> 
		<td><?= $form->field($model, 'VATRate')->textInput() ?></td>
		<td></td>
    </tr>	
	</table>
    <div class="form-group">
        <?= ($Rights[$FormID]['Edit'] OR $Rights[$FormID]['Insert']) ? Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'bigbtn btn-success' : 'bigbtn btn-primary']) : ''; ?>
		<?= Html::a('Cancel', ['index'], ['class' => 'bigbtn btn-cancel']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
