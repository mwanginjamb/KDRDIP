<?php
use yii\helpers\Url;
$url = Url::home(true);
$id = $model->ProjectID;
?>
<div class="row">
	<div class="col-md-4">
		<a href="#" onclick="loadpage('<?= $url; ?>/projects/safeguards?id=<?= $id; ?>&op=0','safeguards')" target="_top">View All</a>
	</div>
	<div class="col-md-4">
		<a href="#" onclick="loadpage('<?= $url; ?>/projects/safeguards?id=<?= $id; ?>&op=1','safeguards')" target="_top">View Yes</a>
	</div>	
	<div class="col-md-4">
		<a href="#" onclick="loadpage('<?= $url; ?>/projects/safeguards?id=<?= $id; ?>&op=2','safeguards')" target="_top">View No</a>
	</div>		
</div>
<table width="100%" class="custom-table table-striped table-bordered" id="ParameterTable">
<thead>
<tr>
	<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">#</td>
	<td style="padding: 4px 4px 4px 4px !important">Parameter</td>
	<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">Yes</td>
	<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%">No</td>
</tr>	
</thead>
<tbody>
<?php
foreach ($projectSafeguards as $key => $parameters) { ?>
	<tr>
		<td style="padding: 4px 4px 4px 4px !important; text-align: left; font-weight: 900; color: black" colspan="4"><?= $key; ?></td>
	</tr>	
	<?php
	foreach ($parameters as $x => $parameter) { ?>
		<tr>
			<td style="padding: 4px 4px 4px 4px !important; text-align: center;" width="5%"><?= $x + 1; ?></td>
			<td style="padding: 4px 4px 4px 4px !important"><?= $parameter['SafeguardParamaterName']; ?></td>
			<td style="padding: 4px 4px 4px 4px !important; text-align: center"><?= $parameter['Yes'] == 1 ? '<i class="la la-check success"></i>' : '' ?></td>
			<td style="padding: 4px 4px 4px 4px !important; text-align: center"><?= $parameter['No'] == 1 ? '<i class="la la-close danger"></i>' : '' ?></td>
		</tr>	
		<?php
	}
} ?>
</tbody>
</table>
<h4 class="form-section">Recomended Action</h4>
<?= $model->SafeguardsRecommendedAction; ?>