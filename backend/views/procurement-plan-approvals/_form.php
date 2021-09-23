<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requisition-form">

    <?php $form = ActiveForm::begin([
    'id' => 'contact-form',
		'fieldConfig' => [
			'options' => ['tag' => false, ],
			'enableClientValidation'=> false,
			'enableAjaxValidation'=> false,
		],
	]); 
	?>
	<table width="100%">
	<tr> 
		<td width="50%"><?= $model->CreatedDate; ?></td>
		<td><?= $model->CreatedBy; ?></td>
    </tr>
	</table>
	<table width="100%" class="table table-striped table-bordered">
	<thead>
	<tr>
		<td width="5%">#</td>
		<td>Product</td>
		<td width="15%">Quantity</td>
		<td width="45%">Description</td>
	</tr>	
	</thead>
	<?php 
	foreach ($lines as $x => $line) 
	{ ?>
		<tr>
			<td><?= $x; ?><?= $form->field($line, '['.$x.']RequisitionLineID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?></td>
			<td><?= $form->field($line, '['.$x.']ProductID', ['template' => '{label}{input}'])->dropDownList($products,['prompt'=>'Select...'])->label(false) ?></td>
			<td><?= $form->field($line, '['.$x.']Quantity', ['template' => '{label}{input}'])->textInput()->label(false) ?></td>
			<td><?= $form->field($line, '['.$x.']Description', ['template' => '{label}{input}'])->textInput()->label(false) ?></td>			
		</tr>
		<?php
	} ?>
	</table>
	<table width="100%">
	<tr> 
		<td width="50%"><?= $form->field($model, 'Notes')->textarea(['rows' => 6]) ?></td>
		<td></td>
    </tr>
	</table>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'bigbtn btn-success' : 'bigbtn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
