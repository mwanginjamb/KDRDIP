<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	@media (max-width:629px) {
	img#logo {
		display: none;
	}
	}
</style>
<div class="col-12 d-flex align-items-center justify-content-center">
	<div class="col-lg-4 col-md-8 col-12 box-shadow-2 p-0">
		<div class="card border-grey border-lighten-3 m-0">
			<div class="card-header border-0">
				<div class="card-title text-center">
					<div class="p-1">
						<!-- <img id="logo" src="<?= $baseUrl; ?>/app-assets/images/logo/appicon.png" alt="branding logo"> -->
					</div>
					<?= $model->FullName; ?>
				</div>
				<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span><?= Html::encode($this->title) ?></span></h6>
			</div>
			<div class="card-content">                                    
				<div class="card-body pt-0">
					<?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal' ]); ?>

					<?= $form->field($model, 'Password', ['options' => ['class' => 'form-group required']])->passwordInput(['autofocus' => true]) ?>
					<?= $form->field($model, 'ConfirmPassword', ['options' => ['class' => 'form-group required']])->passwordInput() ?>

					<div class="form-group">
						<?= Html::a('<i class="ft-x"></i> Close', ['view', 'id' => $model->UserID], ['class' => 'btn btn-warning mr-1']) ?>
						<?= Html::submitButton('<i class="ft-unlock"></i> Change Password', ['class' => 'btn btn-outline-info btn-block1', 'name' => 'login-button']) ?>
					</div>
					
					<?php ActiveForm::end(); ?>                                        
				</div>
				
			</div>
		</div>
	</div>
</div>

