<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<section id="configuration">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="form-section" style="margin-bottom: 0px"><?= $this->title; ?></h4>
					
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
							<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
							<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							<!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
						</ul>
					</div>
				</div>
				<div class="card-content collapse show">
					<div class="card-body">	

						<p>
							<?= Html::a('<i class="ft-x"></i> Cancel', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->UserID], ['class' => 'btn btn-primary']) : '' ?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->UserID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : '' ?>
							<?= Html::a('<i class="ft-lock"></i> Change Password', ['change-password', 'id' => $model->UserID], ['class' => 'btn btn-primary']) ?>
						</p>

						<ul class="nav nav-tabs nav-top-border no-hover-bg">
							<li class="nav-item">
								<a class="nav-link <?= ($activeTab == 1 ? 'active' : ''); ?>" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">User Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?= ($activeTab == 2 ? 'active' : ''); ?>" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Member of</a>
							</li>			
						</ul>
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane <?= ($activeTab == 1 ? 'active' : ''); ?>" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
								<h4 class="form-section">User Details</h4>

								<?= DetailView::widget([
									'model' => $model,
									'attributes' => [
											'UserID',
											'FirstName',
											'LastName',
											'Email:email',
											'Mobile',
											'userstatus.UserStatusName',
											'usergroups.UserGroupName',
											'userTypes.UserTypeName',
											'communities.CommunityName',
											'counties.CountyName',
											[
												'attribute' => 'CreatedDate',
												'format' => ['date', 'php:d/m/Y h:i a'],
												
											],
											[
												'label' => 'Created By',
												'attribute' => 'users.fullName',
												
											],
									],
								]) ?>
							</div>

							<div role="tabpanel" class="tab-pane <?= ($activeTab == 2 ? 'active' : ''); ?>" id="tab2" aria-expanded="true" aria-labelledby="base-tab2">
								<h4 class="form-section">Member of</h4>
								<?php $form = ActiveForm::begin(); ?>
									<div class="row">
										<div class="col-md-4">					
											<?= $form->field($permissionForm, 'UserGroupID')->dropDownList($userGroups, ['prompt' => 'Select...']) ?>
										</div>
										<div class="col-md-8">
											<?= Html::submitButton('<i class="ft-plus"></i> Add', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px']) ?>
										</div>
									</div>								
								<?php ActiveForm::end(); ?>

								<?= GridView::widget([
									'dataProvider' => $dataProvider,
									'layout' => '{items}',
									'tableOptions' => [
										'class' => 'custom-table table-striped table-bordered zero-configuration1',
									],
									'columns' => [
										[
											'class' => 'yii\grid\SerialColumn',
											'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
										],		
										[
											'label'=>'Group',
											'headerOptions' => ['style'=>'color:black; text-align:left'],
											'format'=>'text',
											'value' => 'userGroups.UserGroupName',
											'contentOptions' => ['style' => 'text-align:left'],
										],
										[
											'class' => 'yii\grid\ActionColumn',
											'headerOptions' => ['width' => '8%', 'style'=>'color:black; text-align:center'],
											'template' => '{delete}',
											'buttons' => [

												'delete' => function ($url, $model) {
													return (Html::a('<i class="ft-trash"></i> Remove', ['remove-group', 'id' => $model->UserGroupMemberID], [
														'class' => 'btn-sm btn-danger btn-xs',
														'data' => [
															'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
															'method' => 'post',
														],
													]));
												},
											],
										],		
									],
								]); ?>

							</div>
						</div>
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
