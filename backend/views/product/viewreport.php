<?php
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="page-default">
	<div class="container">
		<iframe src="data:application/pdf;base64,<?= $content; ?>" height="700px" width="100%"></iframe>
	</div>	
</section>