<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- BEGIN: Content-->
<div class="app-content content">
	<div class="content-header row">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
				<section class="flexbox-container">
					<div class="col-12 d-flex align-items-center justify-content-center">
						<div class="col-lg-4 col-md-8 col-5 box-shadow-2 p-0">
								<div class="card border-grey border-lighten-3 m-0">
									<div class="card-header border-0">
										<div class="card-title text-center">
												<div class="p-1"><img src="<?= $baseUrl; ?>/app-assets/images/logo/appicon.png" alt="branding logo"></div>
										</div>
										<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span><?= Html::encode($this->title) ?></span></h6>
									</div>
									<div class="card-content">                                    
										<div class="card-body pt-0">
											<?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal' ]); ?>

											<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

											<?= $form->field($model, 'password')->passwordInput() ?>													

											<div class="form-group row">
												<div class="col-sm-6 col-12 text-center text-sm-left">
													<?= $form->field($model, 'rememberMe')->checkbox(['class' => 'chk-remember']) ?>
												</div>
												<div class="col-sm-6 col-12 float-sm-left text-center text-sm-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div>
											</div>
											
											<?= Html::submitButton('Login', ['class' => 'btn btn-outline-info btn-block', 'name' => 'login-button']) ?>
											
											<?php ActiveForm::end(); ?>                                        
										</div>
										
									</div>
								</div>
						</div>
					</div>
				</section>

		</div>
	</div>
</div>
<!-- END: Content-->
