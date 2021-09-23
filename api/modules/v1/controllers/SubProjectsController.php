<?php

namespace api\modules\v1\controllers;

use yii;
use app\models\Support;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use app\models\Projects;
use yii\data\ActiveDataProvider;

use yii\rest\ActiveController;

/**
 * Support Controller API
 *
 * @author Joseph
 */
class SubProjectsController extends ActiveController
{
	public $modelClass = 'app\models\Projects';

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::class,
			'cors' => [
					'Origin' => ['capacitor://localhost',
									'ionic://localhost',
									'http://localhost',
									'http://localhost:8080',
									'http://localhost:8100'],
					'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
					'Access-Control-Request-Headers' => ['*'],
					'Access-Control-Allow-Credentials' => true,
					'Access-Control-Max-Age' => 86400,
			],
		];
		
		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::class,
		];

		return $behaviors;
	}

	protected function verbs()
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::class,
				'actions' => [
					'index'  => ['get'],
					'view'   => ['get'],
					'create' => ['get', 'post'],
					'update' => ['get', 'put', 'post'],
					'delete' => ['post', 'delete'],
				],
			],
		];
	}

	public function actions()
	{
		$actions = parent::actions();
		// unset($actions['index']);
		// unset($actions['view']);
		unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		return $actions;
	}
	
	public function actionCsv()
	{
		$model = Projects::find()->select('ProjectID, ProjectName, CountyID, SubCountyID, WardID')->asArray()->all();
		// print_r($model); exit;
		$filename = 'SubProjects_' . (string) time();

		require_once 'PHPExcel/PHPExcel/IOFactory.php';
		$objPHPExcel = new \PHPExcel(); // Create new PHPExcel object
		$objPHPExcel->getProperties()->setCreator('M & E System')
		->setLastModifiedBy('M & E System')
		->setTitle('')
		->setSubject('')
		->setDescription('')
		->setKeywords('')
		->setCategory('');
		// create style
		$default_border = [
									'style' => \PHPExcel_Style_Border::BORDER_THIN,
									'color' => ['rgb' => '1006A3']
								];
		$style_header = [
								'borders' => [
													'bottom' => $default_border,
													'left' => $default_border,
													'top' => $default_border,
													'right' => $default_border,
												],
												'fill' => [
													'type' => \PHPExcel_Style_Fill::FILL_SOLID,
													'color' => ['rgb' => 'E1E0F7'],
												],
												'font' => [
													'bold' => true,
													'size' => 12,
												]
								];
		$style_content = [
			'borders' => [
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			],
			'fill' => [
				'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['rgb' => 'eeeeee'],
			],
			'font' => [
				'size' => 12,
			]
		];

		// Create Header
		$firstRow = $model[0];
		$diplayFields = ['SubProjectID', 'SubProjectName', 'CountyID', 'SubCountyID', 'WardID'];
		$column = 'A';
		foreach ($diplayFields as $key => $value) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . '1', $value);
			// set Column Width
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
			$column ++;
		}
		$objPHPExcel->getActiveSheet()->getStyle('A1:' . $column . '1')->applyFromArray($style_header); // give style to header
		
		// Create Data
		$column = 'A';
		$firststyle='A2';
		$row = 2;
		foreach ($model as $rows) {
			$column = 'A';
			foreach ($rows as $key => $value) {				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . (string) $row, $value);
				$column ++;
			}
			$row ++;
		}
		$laststyle = $column . $row;
		$objPHPExcel->getActiveSheet()->getStyle($firststyle . ':' . $laststyle)->applyFromArray($style_content); // give style to header
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($filename);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $filename . '.csv'); // file name of excel
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter->save('php://output');
		exit;
	}
}
