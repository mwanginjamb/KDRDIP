<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub-Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
	$(document).ready(function() {
		$('#DataTables_Table_0_wrapper').DataTable({
			dexampleom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	});
</script>

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
						<div class="form-actions" style="margin-top:0px">
							<?= (isset($rights->Create)) ? Html::a('<i class="ft-plus"></i> Add', ['create', 'cid' => $cid, 'etid' => $etid], ['class' => 'btn btn-primary mr-1']) : '' ?>
							<?php Html::a('<i class="ft-download"></i> Export', ['export', 'cid' => $cid, 'etid' => $etid], ['class' => 'btn btn-secondary mr-1']) ?>
							<?php Html::a('<i class="ft-upload"></i> Import Projects', ['import', 'cid' => $cid, 'etid' => $etid], ['class' => 'btn btn-secondary mr-1']) ?>
							<?= Html::a('<i class="fa fa-file-excel"></i> Excel Import', ['excel-import'], ['class' => 'btn btn-success mr-1', 'title' =>  'Do a batch upload of sub-project via an Excel Sheet. ']) ?>
							<?= Html::a('<i class="fa fa-download"></i> Download Template', \yii\helpers\Url::home(true) . "templates/sub-projects-template.xlsx", ['class' => 'btn btn-info mr-1', 'title' => 'Get data import sample excel template here.']) ?>

						</div>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'columns' => [
								[
									'attribute' => 'ProjectID',
									'label' => 'ID',
									'headerOptions' => ['width' => '5%'],
								],
								'ProjectName',
								[
									'label' => 'Sector',
									'attribute' => 'projectSectors.ProjectSectorName',
									'headerOptions' => ['width' => '25%'],
								],
								[
									'label' => 'Financial Year',
									'attribute' => 'financial_year',
									'value' => 'fy.year'
								],
								[
									'attribute' => 'StartDate',
									'headerOptions' => ['width' => '10%'],
									'format' => ['date', 'php:d/m/Y'],
								],
								[
									'attribute' => 'County',
									'headerOptions' => ['width' => '10%'],
									'value' => 'counties.CountyName',
								],

								[
									'attribute' => 'projectStatus.ProjectStatusName',
									'label' => 'Status',
									'headerOptions' => ['width' => '10%'],
								],
								/* [
									'attribute' => 'CreatedDate',
									'format' => ['date', 'php:d/m/Y h:i a'],
									'headerOptions' => ['width' => '15%'],
								], */
								/* 	[
									'label' => 'Created By',
									'attribute' => 'users.fullName',
									'headerOptions' => ['width' => '15%'],
								], */
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style' => 'color:black; text-align:center'],
									'template' => '{view} {delete}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->ProjectID], ['class' => 'btn-sm btn-primary']) : '';
										},
										'delete' => function ($url, $model) {
											return Html::a('<i class="ft-trash"></i> Delete', ['delete'], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'params' => [
														'id' => $model->ProjectID
													],
													'method' => 'post',
												],
											]);
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