<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\UserGroups */

$this->title = $model->UserGroupName;
$this->params['breadcrumbs'][] = ['label' => 'User Groups', 'url' => ['index']];
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
							<?= Html::a('<i class="ft-x"></i> Close', ['index'], ['class' => 'btn btn-warning mr-1']) ?>
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->UserGroupID], ['class' => 'btn btn-primary']) : '';?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->UserGroupID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : ''?>
						</p>

						<?= DetailView::widget([
							'model' => $model,
							'attributes' => [
									'UserGroupID',
									'UserGroupName',
									'Notes:ntext',
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

						
						<h4 class="form-section">Permissions</h4>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration1',
							],
							'columns' => [
								[
									'label'=>'ID',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
									'contentOptions' => ['style' => 'text-align:center'],
									'format'=>'text',
									'value' => 'UserGroupRightID',
									'contentOptions' => ['style' => 'text-align:left'],
								],		
								[
									'label'=>'Function',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'pages.PageName',
									'contentOptions' => ['style' => 'text-align:left'],
								],				
								[
									'label'=>'View',
									'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:center'],
									'format'=>'text',
									'value' => 'View_Name',
									'contentOptions' => ['style' => 'text-align:center'],
								],
								[
									'label'=>'Create',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:center'],
									'format'=>'text',
									'value' => 'Create_Name',
									'contentOptions' => ['style' => 'text-align:center'],
								],		
								[
									'label'=>'Edit',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:center'],
									'format'=>'text',
									'value' => 'Edit_Name',
									'contentOptions' => ['style' => 'text-align:center'],
								],	
								[
									'label'=>'Delete',
									'headerOptions' => ['width' => '10%','style'=>'color:black; text-align:center'],
									'format'=>'text',
									'value' => 'Delete_Name',
									'contentOptions' => ['style' => 'text-align:center'],
								],		
							],
						]); ?>
					</div>
				</div>
			</div>																			
		</div>
	</div>
</section>
