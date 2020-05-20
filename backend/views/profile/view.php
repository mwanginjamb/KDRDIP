<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */

$this->title = 'Profile: ' . $model->FullName;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content-body">
	<!-- Zero configuration table -->
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
								<?= Html::a('<i class="ft-x"></i> Close', ['/site/index'], ['class' => 'btn btn-warning mr-1']) ?>
								<?= (isset($rights->Edit)) ? Html::a('<i class="ft-edit"></i> Update', ['update', 'id' => $model->UserID], ['class' => 'btn btn-primary']) : ''?>
							</p>

							<?= DetailView::widget([
								'model' => $model,
								'attributes' => [
									'UserID',
									'FirstName',
									'LastName',
									'Mobile',
									'Email:email',
									[
										'label' => 'Group',
										'attribute' => 'usergroups.UserGroupName',
									],
									[
										'label' => 'Status',
										'attribute' => 'userstatus.UserStatusName',
									],
									[
										'attribute'=>'CreatedDate',
										'format'=>['DateTime','php:d/m/Y h:i a']
									],
									[
										'attribute' => 'users.FullName',
										'label' => 'Created By'
									]
								],
							]) ?>
						</div>
					</div>
				</div>																			
			</div>
		</div>
	</section>
	<!--/ Zero configuration table -->
</div>