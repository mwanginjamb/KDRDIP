<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks Assigned';

$this->params['breadcrumbs'][] = $this->title;

$Rights = Yii::$app->params['rights'];
$FormID = 13;
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
					<div class="card-body card-dashboard">
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'showFooter' =>false,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered',
							],
							'columns' => [

								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'label'=>'Description',
									'headerOptions' => ['style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'TaskName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label'=>'Milestone',
									'headerOptions' => ['width' => '15%', 'style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'taskMilestones.TaskMilestoneName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'label' => 'Status',
									'attribute' => 'taskStatus.TaskStatusName',
									'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:right'],
									'contentOptions' => ['style' => 'text-align:right'],
									'format'=>'text',
								],
								[
									'attribute' => 'StartDate',
									'format' => ['date', 'php:d/m/Y'],
									'headerOptions' => ['width' => '10%'],
								],
								[
									'attribute' => 'DueDate',
									'format' => ['date', 'php:d/m/Y'],
									'headerOptions' => ['width' => '10%'],
								],
								[
									'label' => 'Assigned To',
									'attribute'=>'assignedToUser.fullName',
									'headerOptions' => ['width' => '10%', 'style'=>'color:black; text-align:right'],
									'contentOptions' => ['style' => 'text-align:right'],
									'format'=>'text',
								],
								[
									'class' => 'yii\grid\ActionColumn', 
									'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
									'template' => '{update}',
									'buttons' => [
										//update button
										'update' => function ($url, $model) use ($rights) {
											$baseUrl = Yii::$app->request->baseUrl;
											return (isset($rights->Delete)) ? Html::a('<i class="ft-eye"></i> Select', $baseUrl . '/tasks-assigned/view?id=' . $model->TaskID, [
												'title' => Yii::t('app', 'Select'),
												'class'=>'btn-sm btn-primary btn-xs',
											]) : '';
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
</section>
