<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\BankAccounts */

$this->title = $model->AccountName;
$this->params['breadcrumbs'][] = ['label' => 'Bank Accounts', 'url' => ['index']];
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
							<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->BankAccountID], ['class' => 'btn btn-primary']) : ''?>
							<?= (isset($rights->Delete)) ? Html::a('<i class="ft-trash"></i> Delete', ['delete', 'id' => $model->BankAccountID], [
									'class' => 'btn btn-danger',
									'data' => [
										'confirm' => 'Are you sure you want to delete this item?',
										'method' => 'post',
									],
							]) : ''?>
						</p>
						<ul class="nav nav-tabs nav-top-border no-hover-bg">
							<li class="nav-item">
								<a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Cash Book</a>
							</li>									
						</ul>
						<div class="tab-content px-1 pt-1">
							<div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
								<h4 class="form-section">Details</h4>

								<?= DetailView::widget([
									'model' => $model,
									'attributes' => [
											'BankAccountID',
											'AccountName',
											'AccountNumber',
											'banks.BankName',
											'bankBranches.BankBranchName',
											'counties.CountyName',
											'communities.CommunityName',
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
							</div>
							<div class="tab-pane" id="tab2" aria-labelledby="base-tab12">
								<h4 class="form-section">Cash Book</h4>
								<div class="form-actions" style="margin-top:0px">
									<?= Html::a('<i class="ft-plus"></i> Transfer', ['cash-book/create', 'baid' => $model->BankAccountID], ['class' => 'btn btn-primary mr-1']) ?>	
								</div>
								<?= GridView::widget([
										'dataProvider' => $cashBook,
										'showFooter' =>false,
										'layout' => '{items}',
										'tableOptions' => [
											'class' => 'custom-table table-striped table-bordered',
										],
										'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
										'columns' => [
											/* [
												'attribute' => 'CashBookID',
												'label' => 'ID',
												'headerOptions' => [ 'width' => '5%', 'style'=>'color:black; text-align:center'],
												'contentOptions' => ['style' => 'text-align:center'],
											], */
											[
												'class' => 'yii\grid\SerialColumn',
												'headerOptions' => ['width' => '5%', 'style'=>'color:black; text-align:left'],
											],
											[
												'attribute' => 'Date',
												'format' => ['date', 'php:d/m/Y'],
												'headerOptions' => ['width' => '10%'],
											],
											[
												'label'=>'Corresponding Acc',
												'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:left'],
												'format'=>'text',
												'attribute' => 'account.AccountName',
												'contentOptions' => ['style' => 'text-align:left'],
											],
											'DocumentReference',
											[
												'label'=>'Description',
												'headerOptions' => ['style'=>'color:black; text-align:left'],
												'format'=>'text',
												'value' => 'Description',
												'contentOptions' => ['style' => 'text-align:left'],
											],
											[
												'label'=>'Debit',
												'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:right'],
												'format'=> ['Decimal',2],
												'value' => 'Debit',
												'contentOptions' => ['style' => 'text-align:right'],
											],
											[
												'label'=>'Credit',
												'headerOptions' => ['width' => '20%', 'style'=>'color:black; text-align:right'],
												'format'=> ['Decimal',2],
												'value' => 'Credit',
												'contentOptions' => ['style' => 'text-align:right'],
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
