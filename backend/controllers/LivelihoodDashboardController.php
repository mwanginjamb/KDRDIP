<?php

namespace backend\controllers;

use Yii;
use app\models\Projects;
use app\models\ProjectBeneficiaries;
use common\models\LoginForm;
use app\models\DashboardFilter;
use app\models\Components;
use app\models\Complaints;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\controllers\RightsController;
use yii\helpers\ArrayHelper;

/**
 * CommunityGroupStatusController implements the CRUD actions for CommunityGroupStatus model.
 */
class LivelihoodDashboardController extends Controller
{
	public $rights;
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$this->rights = RightsController::Permissions(130);

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
	 * Lists all CommunityGroupStatus models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$complaintsArray = ArrayHelper::map(Complaints::find()
			->select(['COUNT(*) AS cnt', 'ComplaintStatusID'])
			->groupBy(['ComplaintStatusID'])
			->asArray()
			->all(), 'ComplaintStatusID', 'cnt');

        // print('<pre>');
        // print_r($complaintsArray); exit;

		$newComplaints = Complaints::find()->andWhere(['ComplaintStatusID' => 1])->limit('10')->orderBy(' CreatedDate DESC')->all();
		$closedComplaints = Complaints::find()->andWhere(['ComplaintStatusID' => 5])->limit('10')->orderBy(' CreatedDate DESC')->all();

		$days = self::getLastNDays(7);
		$weeks = self::getLastNWeeks(8);
		$months = self::getLastNMonths(8);
                    //["1st", "2nd", "3rd", "4th", "5th", "6th", "7th"];
        $dayData = [0, 4500, 2600, 6100, 2600, 6500, 3200];
                    // ["W1", "W2", "W4", "W5", "W6", "W7", "W8"];
        $weekData = [77000, 18000, 61000, 26000, 58000, 32000, 70000, 45000];
                    // ["AUG", "SEP", "OTC", "NOV", "DEC", "JAN", "FEB"];
        $monthData = [100000, 500000, 300000, 700000, 100000, 200000, 700000, 400000];


        // Complaints by Status
		$complaintsStatus = $this->complaintsByStatus();
        $complaintSectors = $this->complaintsBySector();
        $beneficiariesSectors = $this->beneficiariesBySector();
        $beneficiariesByCategory = $this->beneficiariesByCategory();
        $beneficiariesByCounty = $this->beneficiariesByCounty();

        // print('<pre>');
        // print_r($beneficiariesSectors); exit;
        
		return $this->render('index', [
			'closedComplaints' => $closedComplaints,
			'complaintsArray' => $complaintsArray,
			'newComplaints' => $newComplaints,
			'days' => $days,
			'weeks' => $weeks,
			'months' => $months,
            'dayData' => $dayData,
            'weekData' => $weekData,
            'monthData' => $monthData,
            'graph2' => $complaintsStatus['graph'],
            'bar2' => $complaintsStatus['bar'],
            'complaintStatus' => $complaintsStatus['data'],
            'graph3' => $complaintSectors['graph'],
            'bar3' => $complaintSectors['bar'],
            'projectSectors' => $complaintSectors['data'],

            'graph4' => $beneficiariesSectors['graph'],
            'bar4' => $beneficiariesSectors['bar'],
            'beneficiariesSectors' => $beneficiariesSectors['data'],

            'graph5' => $beneficiariesByCategory['graph'],
            'bar5' => $beneficiariesByCategory['bar'],
            'beneficiariesByCategory' => $beneficiariesByCategory['data'],
            'beneficiariesByCounty' => $beneficiariesByCounty['data'],
		]);
	}

    public function complaintsByStatus()
    {
        $sql = 'select complaintstatus.ComplaintStatusID, ComplaintStatusName, Total from(
                    select ComplaintStatusID, count(*) as Total from complaints 
                    GROUP BY ComplaintStatusID
                ) temp
                right join complaintstatus on complaintstatus.ComplaintStatusID = temp.ComplaintStatusID';
        $model = Complaints::findBySql($sql)->asArray()->all();

        $graph = '[';
        foreach ($model as $key => $status) {
            $graph .= '{ label: "' . $status['ComplaintStatusName'] . '",';
            $graph .=	' value: ' . (integer) $status['Total'] . ' },';
        }
        $graph .= ']';

        $bar = '[';
        foreach ($model as $key => $status) {
            if ($key+1 != count($model)) {
                $bar .= '{ y: "' . $status['ComplaintStatusName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' },';
            } else {
                $bar .= '{ y: "' . $status['ComplaintStatusName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' }';
            }			
        }
        $bar .= ']';

        return ['bar' => $bar, 'graph' => $graph, 'data' => $model];
    }

    public function complaintsBySector()
    {
        $sql = "select projectsectors.ProjectSectorID, ProjectSectorName, Total from(
                    select ProjectSectorID, count(*) as Total from complaints 
                    LEFT JOIN projects on projects.ProjectID = complaints.ProjectID
                    GROUP BY ProjectSectorID
                ) temp
                right join projectsectors on projectsectors.ProjectSectorID = temp.ProjectSectorID";
        $model = Complaints::findBySql($sql)->asArray()->all();

        $graph = '[';
        foreach ($model as $key => $status) {
            $graph .= '{ label: "' . $status['ProjectSectorName'] . '",';
            $graph .=	' value: ' . (integer) $status['Total'] . ' },';
        }
        $graph .= ']';

        $bar = '[';
        foreach ($model as $key => $status) {
            if ($key+1 != count($model)) {
                $bar .= '{ y: "' . $status['ProjectSectorName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' },';
            } else {
                $bar .= '{ y: "' . $status['ProjectSectorName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' }';
            }			
        }
        $bar .= ']';

        return ['bar' => $bar, 'graph' => $graph, 'data' => $model];
    }

    public function beneficiariesBySector()
    {
        $sql = "select projectsectors.ProjectSectorID, ProjectSectorName, Total from(
                    select ProjectSectorID, sum(Women + Men + Youth + Minority) as Total from projectbeneficiaries 
                    LEFT JOIN projects on projects.ProjectID = projectbeneficiaries.ProjectID
                    GROUP BY ProjectSectorID
                ) temp
                right join projectsectors on projectsectors.ProjectSectorID = temp.ProjectSectorID";
        $model = ProjectBeneficiaries::findBySql($sql)->asArray()->all();

        $graph = '[';
        foreach ($model as $key => $status) {
            $graph .= '{ label: "' . $status['ProjectSectorName'] . '",';
            $graph .=	' value: ' . (integer) $status['Total'] . ' },';
        }
        $graph .= ']';

        $bar = '[';
        foreach ($model as $key => $status) {
            if ($key+1 != count($model)) {
                $bar .= '{ y: "' . $status['ProjectSectorName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' },';
            } else {
                $bar .= '{ y: "' . $status['ProjectSectorName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' }';
            }			
        }
        $bar .= ']';

        return ['bar' => $bar, 'graph' => $graph, 'data' => $model];
    }

    public function beneficiariesByCategory()
    {
        $sql = "select CategoryID, Total from(
                select 1 as CategoryID, sum(Women) as Total from projectbeneficiaries 
                UNION select 2 as CategoryID, sum(Men) as Total from projectbeneficiaries 
                UNION select 3 as CategoryID, sum(Youth) as Total from projectbeneficiaries 
                UNION select 4 as CategoryID, sum(Minority) as Total from projectbeneficiaries 
                ) temp";
        $beneficiaries = ProjectBeneficiaries::findBySql($sql)->asArray()->all();
        $data = ArrayHelper::index($beneficiaries, 'CategoryID');
        /* print('<pre>');
        print_r($data); exit; */

        $categories = [1 => 'Women', 2 => 'Men', 3 => 'Youth', 4 => 'Minority'];
        
        foreach($categories as $key => $category) {
            $model[] = [
                'CategoryID' => $key,
                'CategoryName' => $category,
                'Total' => isset($data[$key]) ? $data[$key]['Total'] : 0, 
            ];
        }

        /* print('<pre>');
        print_r($model); exit; */

        $graph = '[';
        foreach ($model as $key => $status) {
            $graph .= '{ label: "' . $status['CategoryName'] . '",';
            $graph .=	' value: ' . (integer) $status['Total'] . ' },';
        }
        $graph .= ']';

        $bar = '[';
        foreach ($model as $key => $status) {
            if ($key+1 != count($model)) {
                $bar .= '{ y: "' . $status['CategoryName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' },';
            } else {
                $bar .= '{ y: "' . $status['CategoryName'] . '",';
                $bar .=	' a: ' . (integer) $status['Total'] . ' }';
            }			
        }
        $bar .= ']';

        return ['bar' => $bar, 'graph' => $graph, 'data' => $model];
    }

    public function beneficiariesByCounty()
    {
        $sql = "select counties.CountyID, CountyName, Women, Men, Youth, Minority from(
                    select projects.CountyID, sum(Women) as Women, sum(Men) as Men,  sum(Youth) as Youth, sum(Minority) as Minority from projectbeneficiaries 
                        LEFT JOIN projects on projects.ProjectID = projectbeneficiaries.ProjectID
                        GROUP BY CountyID
                ) temp
                right join (select * from counties where CountyID IN (23, 8, 7))counties on counties.CountyID = temp.CountyID";
    
        $model = ProjectBeneficiaries::findBySql($sql)->asArray()->all();

        $data = '[';
        foreach ($model as $key => $county) {
            $data .= '{ y: "' . $county['CountyName'] . '",';
            $data .= ' a: ' . (integer) $county['Women'] . ',';
            $data .= ' b: ' . (integer) $county['Men'] . ',';
            $data .= ' c: ' . (integer) $county['Youth'] . ',';
            $data .= ' d: ' . (integer) $county['Minority'] . ' },';
        }
        $data .= ']';

        /* print('<pre>');
        print_r($data); exit; */

        return ['data' => $data];
    }

	/**
	 * Finds the CommunityGroupStatus model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CommunityGroupStatus the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Projects::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public static function getLastNDays($days, $format = 'd/m')
	{
		$m = date('m');
		$de = date('d');
		$y= date('Y');
		$dateArray = [];
		for ($i=0; $i <= $days-1; $i++) {
			$dateArray[] = '"' . date($format, mktime(0, 0, 0, $m, ($de-$i), $y)) . '"';
		}
		return array_reverse($dateArray);
	}

	public static function getLastNWeeks($weeks, $format = 'd/m')
	{
		$date = new \DateTime();
		$weekArray = [];
		for ($i=0; $i <= $weeks -1; $i++) {
			$week = $date->format('W');
			date_sub($date, date_interval_create_from_date_string('7 days'));
			$weekArray[] = '"W' . $week . '"';
		}
		return array_reverse($weekArray);
	}

	public static function getLastNMonths($months)
	{
		$date = new \DateTime();
		$monthArray = [];
		for ($i = 0; $i < $months; $i++) {
			$date->modify('last day of last month');
			$monthArray[] = '"' . $date->format('M') . '"';
		}
		return array_reverse($monthArray);
	}
}
