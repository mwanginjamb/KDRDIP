<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($option==1) ? 'Procurement Plan Activity Review' : 'Procurement Plan Activity Approvals';
switch ($option) {
	case 1:
		$this->title = 'Procurement Plan Activity Review';
		break;
	case 2:
		$this->title = 'Procurement Plan Activity Approvals';
		break;
	case 3:
		$this->title = 'Procurement Plan Activity Approved';
		break;
	case 4:
		$this->title = 'Procurement Plan Activity Rejected';
		break;
	default:
		$this->title = 'Procurement Plan Activity Review';
}
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
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
								],
								[
									'attribute' => 'ServiceDescription',
								],
								[
									'label' => 'Unit',
									'attribute' => 'unitsOfMeasure.UnitOfMeasureName',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'label'=>'Quantity',
									'format'=> ['decimal', 2],
									'attribute' => 'Quantity',
									'headerOptions' => ['width' => '10%', 'style'=>'text-align:right'],
									'contentOptions' => ['style' => 'text-align:right'],
								],
								[
									'attribute' => 'procurementMethods.ProcurementMethodName',
									'headerOptions' => ['width' => '10%'],
								],
								[
									'attribute' => 'SourcesOfFunds',
									'headerOptions' => ['width' => '10%'],
								],		
								[
									'label'=>'Status',
									'headerOptions' => ['width' => '12%','style'=>'color:black; text-align:left'],
									'format'=>'text',
									'value' => 'approvalstatus.ApprovalStatusName',
									'contentOptions' => ['style' => 'text-align:left'],
								],
								[
									'class' => 'yii\grid\ActionColumn', 
									'headerOptions' => ['width' => '7%', 'style'=>'color:black; text-align:center'],
									'template' => '{update}',
									'buttons' => [
										//update button
										'update' => function ($url, $model) use ($Rights, $FormID, $option, $rights) {
											$baseUrl = Yii::$app->request->baseUrl;
											return (isset($rights->Delete)) ? Html::a('<i class="ft-eye"></i> Select', $baseUrl . '/procurement-line-approvals/view?id=' . $model->ProcurementPlanLineID.'&option=' . $option, [
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
