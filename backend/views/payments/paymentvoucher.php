<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Payment Voucher';
?>
<div class="title"><?= $this->title; ?></div>
<div class="company-name">KENYA DEVELOPMENT RESPONSE TO DISPLACEMENT IMPACTS PROJECT</div>
<div class="space"></div>
<table width="100%">
	<tr>
		<td ></td>
		<td width="20%" align="right">Voucher No.: </td>
		<td width="12%"><?= $model->PaymentID; ?></td>
	</tr>
	<tr>
		<td></td>
		<td width="20%" align="right">Date: </td>
		<td width="12%"><?= date('d/m/Y', strtotime($model->Date)); ?></td>
	</tr>
</table>
<div class="space"></div>
<div class="supplier-name">Pay to1: <?= $model->suppliers->SupplierName; ?></div>
<div class="space"></div>
<table class="pdf-table">
	<thead>
		<tr>
			<th width="10%">Ref. No.</th>
			<th >Description</th>
			<th width="20%" class="number-column">Amount</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $model->RefNumber; ?></td>
			<td><?= $model->Description; ?></td>
			<td class="number-column"><?= number_format($model->Amount, 2); ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">Total</th>
			<th class="number-column">Amount</th>
		</tr>
	</tfoot>
</table>

<table width="100%">
	<tr>
		<td width="20%">Payment Method: </td>
		<td><?= $model->paymentMethods->PaymentMethodName; ?></td>
	</tr>
</table>
<table width="100%" class="pdf-signoff-table">
	<tr>
		<td width="15%">Bank Account: </td>
		<td><?= $model->bankAccounts->AccountName; ?></td>
		<td width="13%">Cheque No.:</td>
		<td width="15%" class="underline"></td>
	</tr>
</table>

<table width="100%" class="pdf-signoff-table">
	<tr>
		<td width="13%">Prepared By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="13%">Prepared By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="13%">Prepared By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
</table>