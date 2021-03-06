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
		<td width="20%" align="right">PV No.: </td>
		<td width="12%"><?= $model->PaymentID; ?></td>
	</tr>
	<tr>
		<td></td>
		<td width="20%" align="right">Date: </td>
		<td width="12%"><?= date('d/m/Y', strtotime($model->Date)); ?></td>
	</tr>
</table>
<div class="space"></div>
<div class="supplier-name">Payee: <?= $model->suppliers->SupplierName; ?></div>
<div class="space"></div>
<table class="pdf-table">
	<thead>
		<tr>
			<th >Particulars</th>
			<th width="15%">LSO/LPO No</th>
			<th width="15%">Receipt No</th>
			<th width="15%">Invoice No</th>
			<th width="15%">Delivery Note No</th>			
			<th width="15%" class="number-column">Amount</th>
		</tr>
	</thead>
	<tbody>
		<tr>			
			<td><?= $model->Description; ?></td>
			<td><?= $model->invoices->PurchaseID; ?></td>
			<td><?= $model->PaymentID; ?></td>
			<td><?= $model->InvoiceID; ?></td>
			<td></td>
			<td class="number-column"><?= number_format($model->Amount, 2); ?></td>
		</tr>
	</tbody>
</table>

<p>Amount in Words (Kshs) <?= $amountWords; ?></p>

<!-- <table width="100%">
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
</table> -->

<table width="100%" class="pdf-signoff-table">
	<tr>
		<td width="14%">Prepared By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="14%">Checked By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
	<tr>
		<td width="14%">Approved By: </td>
		<td width="32%" class="underline"></td>
		<td width="10%">Signature:</td>
		<td width="25%" class="underline"></td>
		<td width="5%">Date:</td>
		<td width="15%" class="underline"></td>
	</tr>
</table>