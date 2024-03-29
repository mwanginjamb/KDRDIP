<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Community Groups';
$this->params['breadcrumbs'][] = $this->title;
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
						<div class="form-actions" style="margin-top:0px">
							<?= Html::a('<i class="ft-plus"></i> Add', ['create'], ['class' => 'btn btn-primary mr-1']) ?>
							<?= Html::a('<i class="fa fa-file-excel"></i> Excel Import', ['excel-import'], ['class' => 'btn btn-success mr-1']) ?>
							<?= Html::a('<i class="fa fa-download"></i> Download Template', \yii\helpers\Url::home(true) . "templates/community-groups.xlsx", ['class' => 'btn btn-info mr-1', 'title' => 'Get data import sample excel template here.']) ?>
						</div>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'layout' => '{items}',
							'tableOptions' => [
								'class' => 'custom-table table-striped table-bordered zero-configuration',
							],
							'columns' => [
								[
									'class' => 'yii\grid\SerialColumn',
									'headerOptions' => ['width' => '5%', 'style' => 'color:black; text-align:left'],
								],
								'OrganizationName',
								[
									'label' => 'Livelihood Activity',
									'attribute' => 'Activities',
									'value' => 'livelihoodActivity.LivelihoodActivityName',
									'headerOptions' => ['width' => '20%'],
								],
								[
									'attribute' => 'RegistrationDate',
									'format' => ['date', 'php:d/m/Y'],
									'headerOptions' => ['width' => '15%'],
								],
								[
									'label' => '# Males',
									'value' => 'Males'
								],
								[
									'label' => '# Females',
									'value' => 'Females'
								],
								'county.CountyName',
								[
									'attribute' => 'subCounty.SubCountyName',
									'headerOptions' => ['width' => '15%'],
								],
								[
									'label' => 'Ward',
									'value' => 'ward.WardName'
								],
								[
									'label' => 'Village',
									'value' => 'subLocation.SubLocationName'
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'headerOptions' => ['width' => '13%', 'style' => 'color:black; text-align:center'],
									'template' => '{view} {delete}',
									'buttons' => [

										'view' => function ($url, $model) use ($rights) {
											return (isset($rights->View)) ? Html::a('<i class="ft-eye"></i> View', ['view', 'id' => $model->OrganizationID], ['class' => 'btn-sm btn-primary']) : '';
										},
										'delete' => function ($url, $model) use ($rights) {
											return (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->OrganizationID], [
												'class' => 'btn-sm btn-danger btn-xs',
												'data' => [
													'confirm' => 'Are you absolutely sure ? You will lose all the information with this action.',
													'method' => 'post',
												],
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