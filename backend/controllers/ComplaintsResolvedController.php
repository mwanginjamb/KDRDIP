<?php

namespace backend\controllers;

use Yii;
use app\models\Complaints;
use app\models\ComplaintTypes;
use app\models\ComplaintTiers;
use app\models\ComplaintChannels;
use app\models\ComplaintPriorities;
use app\models\ComplaintStatus;
use app\models\SubLocations;
use app\models\ComplaintNotes;
use app\models\AssignedForm;
use app\models\Counties;
use app\models\Components;
use app\models\Projects;
use app\models\SubCounties;
use app\models\Wards;
use app\models\Users;
use app\models\ComplaintsFilter;
use app\models\Documents;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;

/**
 * ComplaintsController implements the CRUD actions for Complaints model.
 */
class ComplaintsResolvedController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(128);

		$rightsArray = [];
		if (isset($this->rights->View)) {
			array_push($rightsArray, 'index', 'view');
		}
		if (isset($this->rights->Create)) {
			array_push($rightsArray, 'view', 'create');
		}
		if (isset($this->rights->Edit)) {
			array_push($rightsArray, 'index', 'view', 'update');
		}
		if (isset($this->rights->Delete)) {
			array_push($rightsArray, 'delete');
		}
		$rightsArray = array_unique($rightsArray);
		
		if (count($rightsArray) <= 0) {
			$rightsArray = ['none'];
		}
		
		return [
		'access' => [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete'],
			'rules' => [
					// Guest Users
					[
						'allow' => true,
						'actions' => ['none'],
						'roles' => ['?'],
					],
					// Authenticated Users
					[
						'allow' => true,
						'actions' => $rightsArray, //['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Complaints models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$filter = new ComplaintsFilter();
		$model = Complaints::find()->joinWith('projects');
		
		if ($filter->load(Yii::$app->request->post()) && $filter->validate()) {
			$params = Yii::$app->request->post()['ComplaintsFilter'];
			foreach ($params as $key => $value) {
				if (isset($params[$key]) && $params[$key] != '') {
					if ($key == 'ComponentID') {
						$model->andWhere(['projects.' . $key => $value]);
					} elseif ($key == 'StartDate') {
						$model->andWhere(['>=', 'complaints.IncidentDate', $value]);
					}  elseif ($key == 'EndDate') {
						$model->andWhere(['<=', 'complaints.IncidentDate', $value]);
					} else {
						$model->andWhere(['complaints.' . $key => $value]);
					}
				}
			}
		}

		$model->andWhere(['complaints.ComplaintStatusID' => 4]);

		$dataProvider = new ActiveDataProvider([
			'query' => $model,
			'pagination' => false,
		]);

		if (isset(Yii::$app->request->post()['print'])) {
			$model->asArray();
			$model->joinWith('complaintTypes');
			$model->joinWith('assignedUser');
			$model->joinWith('complaintStatus');
			$model->joinWith('users');
			$dataProvider = new ActiveDataProvider([
				'query' => $model,
				'pagination' => false,
			]);
			// print conplaints List in PDF
			return $this->print($dataProvider, $filter);
		} elseif (isset(Yii::$app->request->post()['download'])) {
			// Download file in excel format\
			$diplayFields = [
				'ComplaintID' => 'Enquery ID',
				'ComplainantName' => 'Customer Name',
				'Mobile' => 'Mobile',
				'ComplaintTypeName' => 'Complaint Type',
				'IncidentDate' => 'Incident Date',
				'AssignedUser' => 'Assigned To',
				'ComplaintStatusName' => 'Complaint Status',
				'CreatedDate' => 'created Time',
				'CreatedBy' => 'created By',
				'ComplaintSummary' => 'Complaint Summary',
			];

			$dataArray = [];
			foreach ($dataProvider->getModels() as $complaint) {
				$dataArray[] = [
					'ComplaintID' => $complaint->ComplaintID,
					'ComplainantName' => $complaint->ComplainantName,
					'Mobile' => $complaint->Mobile,
					'ComplaintTypeName' => isset($complaint->complaintTypes) ? $complaint->complaintTypes->ComplaintTypeName : '',
					'IncidentDate' => date('Y-m-d', strtotime($complaint->IncidentDate)),
					'AssignedUser' => isset($complaint->assignedUser) ? $complaint->assignedUser->fullName : '',
					'ComplaintStatusName' => isset($complaint->complaintStatus) ? $complaint->complaintStatus->ComplaintStatusName : '',
					'CreatedDate' => date('Y-m-d H:i', strtotime($complaint->CreatedDate)),
					'CreatedBy' =>  $complaint->users->fullName,
					'ComplaintSummary' => $complaint->ComplaintSummary,
				];
			}

			$this->download($dataArray, $filename = 'Complaints List', $diplayFields);
		}

		$complaintTypes = ArrayHelper::map(ComplaintTypes::find()->orderBy('ComplaintTypeName')->all(), 'ComplaintTypeID', 'ComplaintTypeName');
		$complaintStatus = ArrayHelper::map(ComplaintStatus::find()->orderBy('ComplaintStatusName')->all(), 'ComplaintStatusID', 'ComplaintStatusName');
		$components = ArrayHelper::map(Components::find()->orderBy('ComponentName')->all(), 'ComponentID', 'ComponentName');
		$projects = ArrayHelper::map(Projects::find()->orderBy('ProjectName')->where(['ComponentID' => $filter->ComponentID])->all(), 'ProjectID', 'ProjectName');
		$counties = ArrayHelper::map(Counties::find()->orderBy('CountyName')->all(), 'CountyID', 'CountyName');
		$subCounties = ArrayHelper::map(SubCounties::find()->orderBy('SubCountyName')->where(['CountyID' => $filter->CountyID])->all(), 'SubCountyID', 'SubCountyName');
		$wards = ArrayHelper::map(Wards::find()->orderBy('WardName')->where(['SubCountyID' => $filter->SubCountyID])->all(), 'WardID', 'WardName');
		
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'rights' => $this->rights,
			'filter' => $filter,
			'complaintTypes' => $complaintTypes,
			'complaintStatus' => $complaintStatus,
			'components' => $components,
			'projects' => $projects,
			'counties' => $counties,
			'subCounties' => $subCounties,
			'wards' => $wards
		]);
	}

	/**
	 * Displays a single Complaints model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$complaintStatus = ArrayHelper::map(ComplaintStatus::find()->andWhere('ComplaintStatusID IN (4, 5)')->all(), 'ComplaintStatusID', 'ComplaintStatusName');
		$users = ArrayHelper::map(Users::find()->all(), 'UserID', 'fullName');

		$assignedForm = new AssignedForm();

		if ($assignedForm->load(Yii::$app->request->post()) && $assignedForm->validate()) {

			// Save Comments
			$notes = new ComplaintNotes();
			$notes->Notes = $assignedForm->comments;
			$notes->ComplaintID = $id;
			$notes->ComplaintStatusID = $assignedForm->complaintStatusId;
			$notes->CreatedBy = Yii::$app->user->identity->UserID;
			$notes->save();

			// Modify the values as sent
			if ($assignedForm->activityId == 2 || $assignedForm->activityId == 3) {
				if ($assignedForm->activityId == 3) {
					$model->ComplaintStatusID = $assignedForm->complaintStatusId;
					if ($assignedForm->complaintStatusId == 4) {
						$model->ResolutionDate = date('Y-m-d H:i:s');
						$model->ResolvedBy = Yii::$app->user->identity->UserID;
					}
				} elseif ($assignedForm->activityId == 2) {
					$model->AssignedTo = $assignedForm->assignedTo;
				}
				$model->save();
				return $this->redirect(['index']);
			}
			return $this->redirect(['view', 'id' => $id]);
		}
		$assignedForm = new AssignedForm();
		$assignedForm->assignedTo = $model->AssignedTo;
		$assignedForm->complaintStatusId = $model->ComplaintStatusID;

		$dataProvider = new ActiveDataProvider([
			'query' => ComplaintNotes::find()->andWhere(['ComplaintID' => $id]),
			'pagination' => false,
			'sort'=> ['defaultOrder' => ['CreatedDate' => SORT_DESC]],
		]);

		$documentProvider = new ActiveDataProvider([
			'query' => Documents::find()->andWhere(['RefNumber' => $id, 'DocumentCategoryID' => 5]),
			'pagination' => false,
			'sort'=> ['defaultOrder' => ['CreatedDate' => SORT_DESC]],
		]);

		return $this->render('view', [
			'model' => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'documentProvider' => $documentProvider,
			'complaintStatus' => $complaintStatus,
			'users' => $users,
			'rights' => $this->rights,
			'assignedForm' => $assignedForm,
		]);
	}

	/**
	 * Finds the Complaints model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Complaints the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Complaints::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	
	public function print($dataProvider, $filter)
	{
		$arrayData = ArrayHelper::index($dataProvider->getModels(), null, 'sectionId');
		// print('<pre>');
		// print_r($arrayData); exit;
		$title = 'Complaints List';
		// get your HTML raw content without any layouts or scripts
		$content = $this->renderPartial('report', ['filter' => $filter, 'arrayData' => $arrayData]);
		
		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_CORE,
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE,
			// stream to browser inline
			'destination' => Pdf::DEST_STRING,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting
			// 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			// 'cssInline' => '.kv-heading-1{font-size:18px}',
			'cssFile' => 'css/pdf.css',
				// set mPDF properties on the fly
			'options' => ['title' => $title],
				// call mPDF methods on the fly
			'methods' => [
				// 'SetHeader'=>[$title],
				'SetFooter' => ['page: {PAGENO}'],
			]
		]);
		// $pdf->defaultfooterline=0;
		
		// return the pdf output as per the destination setting
		//return $pdf->render();
		$content = $pdf->render('', 'S');
		$content = chunk_split(base64_encode($content));		
		
		//$pdf->Output('test.pdf', 'F');
		return $this->render('viewreport', [
			'content' => $content,
		]);
	}

	public static function download($model = [], $filename = 'Excel File', $diplayFields = [])
	{
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
		$firstRow = isset($model[0]) ? $model[0] : [];
		$column = 'A';
		foreach ($firstRow as $key => $value) {
			// if (in_array($key, $diplayFields)) {
			if (self::findKey($diplayFields, $key)) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . '1', $diplayFields[$key]);
				// set Column Width
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(20);
				$column ++;
			}
		}
		if ($model) {
			$column = chr(ord($column) - 1); // Decrement
			$objPHPExcel->getActiveSheet()->getStyle('A1:' . $column . '1')->applyFromArray($style_header); // give style to header
			
			// Create Data
			$column = 'A';
			$firststyle='A2';
			$row = 1;
			foreach ($model as $rows) {
				$column = 'A';
				$row ++;
				foreach ($rows as $key => $value) {
					if (self::findKey($diplayFields, $key)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column . (string) $row, $value);
						$column ++;
					}
				}
			}
			$column = chr(ord($column) - 1); // Decrement
			$laststyle = $column . $row;
			$objPHPExcel->getActiveSheet()->getStyle($firststyle . ':' . $laststyle)->applyFromArray($style_content); // give style to header
		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($filename);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $filename . '.xls'); // file name of excel
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public static function findKey($array, $keySearch)
	{
		foreach ($array as $key => $item) {
			if ($key == $keySearch) {
				return true;
			} elseif (is_array($item) && self::findKey($item, $keySearch)) {
				return true;
			}
		}
		return false;
	}
}
