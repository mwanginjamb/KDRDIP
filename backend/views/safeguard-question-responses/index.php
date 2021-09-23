<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Safeguard Question Responses';
$this->params['breadcrumbs'][] = $this->title;

$formId = 'currentForm' . $tab;
?>

<style>
#questionsTable .form-group {
	margin-bottom: 0px !important;
	margin-top: 0px !important;
	/* padding: 4px !important; */
	width: 90%;
}
</style>
<h4 class="form-section" style="margin-bottom: 0px">Questions</h4>
<?php $form = ActiveForm::begin(['id' => $formId, 'options' => ['enctype' => 'multipart/form-data']]); ?>
	<table width="100%" class="custom-table table-striped table-bordered zero-configuration" id="questionsTable">
	<thead>
	<tr>
		<td style="padding: 4px !important; text-align: center;" width="5%">#</td>
		<td style="padding: 4px !important">Question</td>
		<td style="padding: 4px !important" width="45%">Question</td>
	</tr>	
	</thead>
	<?php 
	foreach ($lines as $x => $line) { ?>
		<tr>
			<td style="text-align: center; vertical-align: top;">
				<?= $x+1; ?><?= $form->field($line, '[' . $x . ']SafeguardQuestionResponseID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
				<?= $form->field($line, '[' . $x . ']SafeguardQuestionID', ['template' => '{label}{input}'])->hiddenInput()->label(false);?>
			</td>
			<td style="vertical-align: top; padding: 4px !important"><?= $line['SafeguardQuestion']; ?></td>
			<td>
				<?php if ($line['SafeguardQuestionTypeID'] == 1) { ?>
					<?= $form->field($line, '[' . $x . ']Response', ['template' => '{label}{input}'])->textInput(['class'=>'form-control', 'type' => 'number'])->label(false) ?>			
					<?php
				} elseif ($line['SafeguardQuestionTypeID'] == 2) { ?> 
					<?= $form->field($line, '[' . $x . ']Response', ['template' => '{label}{input}'])->textarea(['rows' => 3, 'class'=>'form-control form-group1'])->label(false) ?>
					<?php
				} elseif ($line['SafeguardQuestionTypeID'] == 3) { ?> 
					<?= $form->field($line, '[' . $x . ']Response', ['template' => '{label}{input}'])->dropDownList($safeguardQuestionOptions[$line['SafeguardQuestionID']], ['prompt'=>'','class'=>'form-control form-group1'])->label(false) ?>
					<?php
				} elseif ($line['SafeguardQuestionTypeID'] == 4) { ?> 
					<?= $form->field($line, '[' . $x . ']Response', ['template' => '{label}{input}'])->dropDownList($yes_No, ['prompt'=>'','class'=>'form-control form-group1'])->label(false) ?>
					<?php
				} ?>
			</td>
		</tr>
		<?php
	} ?>			
	</table>

	<div class="form-group">
		<?= Html::a('<i class="ft-x"></i> Close', null, ['class' => 'btn btn-warning mr-1' , 'onclick' => 'loadpage("' . Yii::$app->urlManager->createUrl('safeguard-question-responses/index?tab=' . $tab .'&categoryId='. $categoryId . '&pId=' . $pId) . '", "' . $tab .'")']) ?>
		<?= Html::a('<i class="la la-check-square-o"></i> Save', null, ['id' => 'saveBtn', 'class' => 'btn btn-primary mr-1', 'onclick' => 'submitForm("' . Yii::$app->urlManager->createUrl('safeguard-question-responses/index?tab=' . $tab .'&categoryId='. $categoryId . '&pId=' . $pId) . '", "'. $tab .'", "' . $formId . '", \'saveBtn\')']) ?>
	</div>

<?php ActiveForm::end(); ?>

