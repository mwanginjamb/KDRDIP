<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileStatus */

$this->title = 'Update Profile Status: ' . $model->ProfileStatusID;
$this->params['breadcrumbs'][] = ['label' => 'Profile Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ProfileStatusID, 'url' => ['view', 'id' => $model->ProfileStatusID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-content content">
	<div class="content-header row">
	</div>
	<div class="content-wrapper">
		<div class="content-body">
			<section class="flexbox-container">
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
					<?= $this->render('_form', [
						'model' => $model,
					]) ?>
				</div>
			</section>
		</div>
	</div>
</div>
