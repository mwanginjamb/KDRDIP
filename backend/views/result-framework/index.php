<?php

use yii\helpers\Html;
use yii\grid\GridView;

$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Result Framework';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?= $baseUrl; ?>/app-assets/js/jquery.min.js"></script>
<style>

</style>
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
					<div style="overflow:auto; width: 100%; height: 550px">

					<table class="custom-table table-striped table-bordered" id="mytable">
						<thead>					
						<?php
						foreach ($model as $x => $indicatorTypes) { ?>
							<tr>
								<td colspan="28"><?= $indicatorTypes['IndicatorTypeName']; ?></td>
							</tr>
							<tr>
								<th width="50px">#</th>
								<th width="300px">Indicator</th>
								<th width="150px" style="text-align: right">Baseline</th>
								<?php for ($x = 0; $x <= 4; $x++) {
									for ($y = 1; $y <= 4; $y++) { ?>
										<th width="150px" style="text-align: right"><?= 'Y' . ($x + 1) . 'Q' . $y . ' Actual'; ?></th>
										<?php
									} ?>
									<th width="150px" style="text-align: right"><?= 'Y' . ($x + 1) . ' Target'; ?></th>
									<?php
								} ?>
							</tr>
							</thead>
							<tbody>
							<?php					
							foreach ($indicatorTypes['resultIndicators'] as  $resultIndicators) { ?>
								<tr>
									<?php print '<pre>'; print_r($resultIndicators); ?>
								</tr>
								<?php
							}
						} ?>	
						</tbody>		
					</table>
					</div>
					</div>
				</div>										  
			</div>
		</div>
	</div>
</section>
