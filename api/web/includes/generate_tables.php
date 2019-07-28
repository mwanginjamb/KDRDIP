<?php 
use app\models\Agency;
use app\models\Complaints;
use yii\data\ActiveDataProvider;
function generate_table($Str, $Ratio=false, $key=false)
{
	$MyArray = json_decode($Str);
	
	$DataArray = $MyArray->data;
	$LabelArray = $MyArray->label;
	$tablestring = '';
	if ($key==false)
	{	
		$tablestring .= '<table class="table striped hovered" style="font-size:80%;">';
		$tablestring .= '<thead><tr>';
		foreach ($LabelArray AS $Key => $Value)
		{
			$tablestring .= '<th width="10%" class="text-left" align="left">'.$Value.'</th>';			
		}
		$tablestring .= '</tr></thead>';
		$tablestring .= '<tr>';
		foreach ($DataArray AS $Key => $Value)
		{
			$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
		}
		$tablestring .= '</tr>';			
		$tablestring .= '</table>';
	}

	if ($Ratio==true)
	{
		$ActualArray = $MyArray->actual;
		//print_r($ActualArray); exit;
		$Cols = count($LabelArray)+1;
		$tablestring .= '<table class="table striped hovered" style="font-size:80%;">';
		$tablestring .= '<thead>';
		$tablestring .= '<tr><th colspan="'.$Cols.'">Actual Values</th></tr>';
		$tablestring .= '<tr>';
		$tablestring .= '<th width="10%" class="text-left" align="left">Description</th>';
		foreach ($LabelArray AS $Key => $Value)
		{
			$tablestring .= '<th width="10%" class="text-left" align="left">'.$Value.'</th>';			
		}
		$tablestring .= '</tr></thead>';
		foreach ($ActualArray AS $period => $row)
		{
			$tablestring .= '<tr>';
			$tablestring .= '<td align="left">'.$period.'</td>';
			foreach ($row AS $Key => $Value)
			{
				$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
			}
			$tablestring .= '</tr>';	
		}		
		$tablestring .= '</table>';
	}

	return $tablestring; 
} 

function generate_table2($Str)
{
	$MyArray = json_decode($Str);
	//print_r($MyArray); exit;
	$DataArray = isset($MyArray->datasets) ? $MyArray->datasets : array();
	$LabelArray = isset($MyArray->labels) ? $MyArray->labels : array();

	$tablestring = '<table class="table striped hovered" style="font-size:80%;">';
	$tablestring .= '<thead><tr>';
	$tablestring .= '<th width="10%" align="left">Agency</th>';
	foreach ($LabelArray AS $Key => $Value)
	{
		$tablestring .= '<th width="10%" class="text-left" align="left">'.$Value.'</th>';			
	}
	$tablestring .= '</tr></thead>';
	foreach ($DataArray AS $Key => $Row)
	{
		$tablestring .= '<tr>';
		$tablestring .= '<td align="left" width="10%">'.$Row->label.'</td>';
		foreach ($Row->data AS $Key => $Value)
		{
			//print_r($Value);
			$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
		}
		$tablestring .= '</tr>';
	}			
	$tablestring .= '</table>';
	return $tablestring; 
}

function generate_table3($Str)
{
	$MyArray = json_decode($Str);
	//$DataArray = $MyArray->data;
	//$LabelArray = $MyArray->label;

	$tablestring = '<table class="table striped hovered" style="font-size:80%;">';
	$tablestring .= '<thead><tr>';
	$tablestring .= '<th align="left">Label</th>';
	$tablestring .= '<th width="20%" class="text-right">Value</th>';
	$tablestring .= '</tr></thead>';
	
	foreach ($MyArray AS $Key => $Value)
	{
		$tablestring .= '<tr>';
		$tablestring .= '<td align="left">'.$Value->label.'</td>';	
		$tablestring .= '<td align="right" class="text-right">'.number_format($Value->value,2).'</td>';	
		$tablestring .= '</tr>';		
	}
				
	$tablestring .= '</table>';
	return $tablestring; 
} 

function pdf_generate_table($Str, $Ratio=false)
{
	$MyArray = json_decode($Str);
	$DataArray = $MyArray->data;
	$LabelArray = $MyArray->label;
	$tablestring = '<table>';
	$tablestring .= '<thead><tr>';
	foreach ($LabelArray AS $Key => $Value)
	{
		$tablestring .= '<th width="10%" align="left">'.$Value.'</th>';			
	}
	$tablestring .= '</tr></thead>';
	$tablestring .= '<tr>';
	foreach ($DataArray AS $Key => $Value)
	{
		$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
	}
	$tablestring .= '</tr>';			
	$tablestring .= '</table>';

	if ($Ratio==true)
	{
		$ActualArray = $MyArray->actual;
		//print_r($ActualArray); exit;
		$Cols = count($LabelArray)+1;
		$tablestring .= '<table>';
		$tablestring .= '<thead>';
		$tablestring .= '<tr><th colspan="'.$Cols.'">Actual Values</th></tr>';
		$tablestring .= '<tr>';
		$tablestring .= '<th width="10%" class="text-left" align="left">Description</th>';
		foreach ($LabelArray AS $Key => $Value)
		{
			$tablestring .= '<th width="10%" class="text-left" align="left">'.$Value.'</th>';			
		}
		$tablestring .= '</tr></thead>';
		foreach ($ActualArray AS $period => $row)
		{
			$tablestring .= '<tr>';
			$tablestring .= '<td align="left">'.$period.'</td>';
			foreach ($row AS $Key => $Value)
			{
				$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
			}
			$tablestring .= '</tr>';	
		}		
		$tablestring .= '</table>';
	}
	$legendstring = '';
	$RetunArray = array('table'=>$tablestring, 'legend'=>$legendstring);
	return $RetunArray; 
} 

function pdf_generate_table2($Str)
{
	$MyArray = json_decode($Str);
	$DataArray = $MyArray->datasets;
	$LabelArray = $MyArray->labels;

	$tablestring = '<table width="100%">';
	$tablestring .= '<thead><tr>';
	$tablestring .= '<th width="10%" align="left">Agency</th>';
	foreach ($LabelArray AS $Key => $Value)
	{
		$tablestring .= '<th width="10%" align="left">'.$Value.'</th>';			
	}
	$tablestring .= '</tr></thead>';
	$legendstring = '';
	foreach ($DataArray AS $Key => $Row)
	{
		$tablestring .= '<tr>';
		$tablestring .= '<td align="left" width="10%" style="background-color:'.$Row->fillColor.'">'.$Row->label.'</td>';
		$legendstring .= '<div style="width:20px; height:20px; background-color:'.$Row->fillColor.'; float:left"></div>';
		$legendstring .= '<div style="float:left; padding: 0 10px 0 10px; width:40px;">'.$Row->label.'</div>';
		foreach ($Row->data AS $Key => $Value)
		{
			$tablestring .= '<td align="left">'.number_format($Value,2).'</td>';			
		}
		$tablestring .= '</tr>';
	}
	$legendstring .= '';			
	$tablestring .= '</table>';
	
	$RetunArray = array('table'=>$tablestring, 'legend'=>$legendstring);
	return $RetunArray; 
}

function pdf_generate_table3($Str,$labelString)
{
	$MyArray = json_decode($Str);
	//$DataArray = $MyArray->data;
	//$LabelArray = $MyArray->label;
	$LabelArray = explode(',',$labelString);

	$tablestring = '<table>';
	$tablestring .= '<thead><tr>';
	$tablestring .= '<th align="left">Label</th>';
	$tablestring .= '<th width="30%" align="left">Value</th>';
	$tablestring .= '</tr></thead>';
	$legendstring = '<div>';
	foreach ($MyArray AS $Key => $Value)
	{
		$legendstring .= '<div style="width:20px; height:20px; background-color:'.$LabelArray[$Key].'; float:left"></div>';
		$legendstring .= '<div style="float:left; padding: 0 10px 0 10px">'.$Value->label.'</div>';		
		$tablestring .= '<tr>';
		$tablestring .= '<td align="left" style="background-color:'.$LabelArray[$Key].'">'.$Value->label.'</td>';	
		$tablestring .= '<td align="left">'.number_format($Value->value,2).'</td>';	
		$tablestring .= '</tr>';		
	}
				
	$tablestring .= '</table>';
	$legendstring .= '</div>';
	$RetunArray = array('table'=>$tablestring, 'legend'=>$legendstring);
	return $RetunArray; 
} 

function pdf_generate_table4($Str)
{
	$MyArray = json_decode($Str);
	$DataArray = $MyArray->datasets;
	$LabelArray = $MyArray->labels;
	
	$recordcount = count($LabelArray);
	
	if ($recordcount<=16)
	{
		$batchArray = array(16);	
	} elseif ($recordcount<=32)
	{
		$batchArray = array(16,16);	
	} else 
	{
		$batchArray = array(16,16,16);	
	}
	
	$tablestring = '';
	$Counter = 0;
	foreach($batchArray AS $Key=>$batchCount)
	{		
		$tablestring .= '<table>';
		$tablestring .= '<thead><tr>';
		$tablestring .= '<th width="10%" align="left" style="font-size:12px">Agency</th>';
		//foreach ($LabelArray AS $Key => $Value)
		for ($x = $Counter; $x < ($Counter+$batchCount); $x++) 
		{
			if (isset($LabelArray[$x]))
			{
				$tablestring .= '<th width="10%" align="left"><span class="rotate" style="font-size:9px">'.$LabelArray[$x].'</span></th>';
			} else
			{
				$tablestring .= '<th width="10%" align="left"><span class="rotate" style="font-size:9px">&nbsp;</span></th>';	
			} 		
		}
		$tablestring .= '</tr></thead>';
		$legendstring = '';
		foreach ($DataArray AS $Key => $Row)
		{
			$tablestring .= '<tr>';
			$tablestring .= '<td align="left" width="10%" style="font-size:9px; background-color:'.$Row->fillColor.'">'.$Row->label.'</td>';
			$legendstring .= '<div style="width:20px; height:20px; font-size:9px; background-color:'.$Row->fillColor.'; float:left"></div>';
			$legendstring .= '<div style="float:left; padding: 0 10px 0 10px; width:40px; font-size:9px">'.$Row->label.'</div>';
			
			//foreach ($Row->data AS $Key => $Value)
			for ($x = $Counter; $x < ($Counter+$batchCount); $x++)
			{
				if (isset($Row->data[$x]))
				{
					$tablestring .= '<td align="left" style="font-size:9px">'.number_format($Row->data[$x],2).'</td>';
				} else
				{
					$tablestring .= '<td align="left" style="font-size:9px">&nbsp;</td>';	
				}		
			}
			$tablestring .= '</tr>';
		}
		$legendstring .= '';			
		$tablestring .= '</table>';
		//$tablestring .= '<div style"height:20px">&nbsp;</div>';
		$Counter = $Counter+$batchCount;
	}
	
	$RetunArray = array('table'=>$tablestring, 'legend'=>$legendstring);
	return $RetunArray; 
}

function graph1_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$CurrentPeriod = $Year;
		$PreviousPeriod = $Year - 1;
		$sql = "SELECT Count(*) as Total, agency_branches.AgencyID, YEAR(complaints.SubmissionDate) AS Period 
				FROM complaints
				RIGHT JOIN users ON users.UserID = complaints.UserID
				RIGHT JOIN agency_branches ON agency_branches.AgencyBranchID = users.AgencyBranchID
				WHERE (YEAR(complaints.SubmissionDate) = '$CurrentPeriod' OR YEAR(complaints.SubmissionDate) ='$PreviousPeriod')
				AND complaints.ComplaintStatusID <> 6
				GROUP BY agency_branches.AgencyID, YEAR(complaints.SubmissionDate)
				";
	} else if ($id == 2)
	{
		$CurrentQuarter = $Quarter;
		$CurrentYear = $Year;
		$PreviousQuater = $Quarter - 1;
		$PreviousYear = $Year;
		if ($CurrentQuarter==4)
		{
			$PreviousYear = $Year-1;
			$PreviousQuater = 1;
		}
		$CurrentPeriod = $CurrentYear.'-'.$CurrentQuarter;
		$PreviousPeriod = $PreviousYear.'-'.$PreviousQuater;
		$sql = "SELECT Count(*) as Total, agency_branches.AgencyID, CONCAT(YEAR(complaints.SubmissionDate),'-',QUARTER(complaints.SubmissionDate)) AS Period 
				FROM complaints
				RIGHT JOIN users ON users.UserID = complaints.UserID
				RIGHT JOIN agency_branches ON agency_branches.AgencyBranchID = users.AgencyBranchID
				WHERE ((YEAR(complaints.SubmissionDate) = '$CurrentYear' AND QUARTER(complaints.SubmissionDate) = '$CurrentQuarter' ) 
				OR (YEAR(complaints.SubmissionDate) ='$PreviousYear' AND QUARTER(complaints.SubmissionDate) = '$PreviousQuater'))
				AND complaints.ComplaintStatusID <> 6
				GROUP BY agency_branches.AgencyID, YEAR(complaints.SubmissionDate), QUARTER(complaints.SubmissionDate)
				";	
	} else if ($id == 3)
	{
		$CurrentMonth = $Month;
		$CurrentYear = $Year;
		$PreviousMonth = $Month - 1;
		$PreviousYear = $Year;
		if ($CurrentMonth==12)
		{
			$PreviousYear = $Year-1;
			$PreviousMonth = 1;
		}
		$CurrentPeriod = $CurrentYear.'-'.$CurrentMonth;
		$PreviousPeriod = $PreviousYear.'-'.$PreviousMonth;
		$sql = "SELECT Count(*) as Total, agency_branches.AgencyID, CONCAT(YEAR(complaints.SubmissionDate),'-',MONTH(complaints.SubmissionDate)) AS Period 
				FROM complaints
				RIGHT JOIN users ON users.UserID = complaints.UserID
				RIGHT JOIN agency_branches ON agency_branches.AgencyBranchID = users.AgencyBranchID
				WHERE ((YEAR(complaints.SubmissionDate) = '$CurrentYear' AND MONTH(complaints.SubmissionDate) = '$CurrentMonth' ) 
				OR (YEAR(complaints.SubmissionDate) ='$PreviousYear' AND MONTH(complaints.SubmissionDate) = '$PreviousMonth'))
				AND complaints.ComplaintStatusID <> 6
				GROUP BY agency_branches.AgencyID, YEAR(complaints.SubmissionDate), MONTH(complaints.SubmissionDate)
				";	
	} else if ($id == 4)
	{
		$CurrentWeek = $Week;
		$CurrentYear = $Year;
		$PreviousWeek = $Week - 1;
		$PreviousYear = $Year;
		$Lastdate =  new DateTime($Year.'-12-31');
		$LastWeek = $Lastdate->format("W");
		if ($CurrentWeek==$LastWeek)
		{
			$PreviousYear = $Year-1;
			$PreviousWeek = 1;
		}
		$CurrentPeriod = $CurrentYear.'-'.$CurrentWeek;
		$PreviousPeriod = $PreviousYear.'-'.$PreviousWeek;
		$sql = "SELECT Count(*) as Total, agency_branches.AgencyID, CONCAT(YEAR(complaints.SubmissionDate),'-',WEEK(complaints.SubmissionDate)) AS Period 
				FROM complaints
				RIGHT JOIN users ON users.UserID = complaints.UserID
				RIGHT JOIN agency_branches ON agency_branches.AgencyBranchID = users.AgencyBranchID
				WHERE ((YEAR(complaints.SubmissionDate) = '$CurrentYear' AND WEEK(complaints.SubmissionDate) = '$CurrentWeek' ) 
				OR (YEAR(complaints.SubmissionDate) ='$PreviousYear' AND WEEK(complaints.SubmissionDate) = '$PreviousWeek'))
				AND complaints.ComplaintStatusID <> 6
				GROUP BY agency_branches.AgencyID, YEAR(complaints.SubmissionDate), WEEK(complaints.SubmissionDate)
				";	
	} else if ($id == 5)
	{
		$CurrentWeek = $Week;
		$CurrentYear = $Year;
		$PreviousWeek = $Week - 1;
		$PreviousYear = $Year;
		$Lastdate =  new DateTime($Year.'-12-31');
		$LastWeek = $Lastdate->format("W");
		if ($CurrentWeek==$LastWeek)
		{
			$PreviousYear = $Year-1;
			$PreviousWeek = 1;
		}
		$CurrentPeriod = $CurrentYear.'-'.$CurrentWeek;
		$PreviousPeriod = $PreviousYear.'-'.$PreviousWeek;
		$sql = "SELECT Count(*) as Total, agency_branches.AgencyID, CONCAT(YEAR(complaints.SubmissionDate),'-',WEEK(complaints.SubmissionDate)) AS Period 
				FROM complaints
				RIGHT JOIN users ON users.UserID = complaints.UserID
				RIGHT JOIN agency_branches ON agency_branches.AgencyBranchID = users.AgencyBranchID
				WHERE ((YEAR(complaints.SubmissionDate) = '$CurrentYear' AND WEEK(complaints.SubmissionDate) = '$CurrentWeek' ) 
				OR (YEAR(complaints.SubmissionDate) ='$PreviousYear' AND WEEK(complaints.SubmissionDate) = '$PreviousWeek'))
				AND complaints.ComplaintStatusID <> 6
				GROUP BY agency_branches.AgencyID, YEAR(complaints.SubmissionDate), WEEK(complaints.SubmissionDate)
				";
	}
	
	$DataArray = array();
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();     
					
	foreach ($s_data AS $key => $row)
	{	
		extract($row);
		if ($Total=='') {$Total =0;}
		$DataArray[$AgencyID][$Period] = $Total;
	}  
	//print_r($DataArray);
	$channel = array();
	$AgencyArray = Agency::find()->asArray()->all();
	
	foreach ($AgencyArray AS $key => $row)
	{
		extract($row);
		$CurentData = 0;
		$PreviousData = 0;
		
		if (isset($DataArray[$AgencyID][$CurrentPeriod]))
			$CurentData 	= $DataArray[$AgencyID][$CurrentPeriod];
		if (isset($DataArray[$AgencyID][$PreviousPeriod]))
			$PreviousData 	= $DataArray[$AgencyID][$PreviousPeriod];
	
			if ($PreviousData==0)
			{
				$Change = 0;
			} else
			{
				$Change = ($CurentData - $PreviousData)/$PreviousData*100;
			}
				
		$channel['data'][] = $Change;
		$channel['label'][] = $AgencyShortName;
		$channel['actual'][$PreviousPeriod][] = $PreviousData;
		$channel['actual'][$CurrentPeriod][] = $CurentData;
	}
	$channel['legend'] = array($PreviousPeriod, $CurrentPeriod);
	$channel['data1'] = $channel['actual'][$PreviousPeriod];
	$channel['data2'] = $channel['actual'][$CurrentPeriod];

	$rss = $channel;  
	$json = json_encode($rss);
	//echo $json; exit;
	return $json;
}

function graph2_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) between '$StartDate' AND '$EndDate'";
	}
	
	$sql = "SELECT agency.AgencyID, agency.AgencyShortName, sum(Opened) AS Opened, sum(received) AS received, sum(received)/sum(Opened)*100 as Ratio FROM 
			(            
				SELECT B1.AgencyID,Count(*) as received,  0 AS Opened 
							FROM complaints
							JOIN users on users.UserID = complaints.UserID
							JOIN agency_branches B1 ON B1.AgencyBranchID = complaints.AgencyBranchID 
							$querystring AND complaints.ComplaintStatusID <> 6
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)
							UNION
							(
							SELECT B1.AgencyID,0 AS received,  Count(*) AS Opened 
							FROM complaints
							JOIN users on users.UserID = complaints.UserID
							JOIN agency_branches B1 ON B1.AgencyBranchID = complaints.AgencyBranchID 
							$querystring AND complaints.ComplaintStatusID <> 6 AND complaints.ComplaintStatusID <> 1
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)           
							)  
				) TEMP
							RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
							GROUP BY agency.AgencyID"; 
	
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Ratio=='') {$Ratio =0;} 
		$channel['data'][] = $Ratio;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['received'][] = $received;
		$channel['actual']['Opened'][] = $Opened;		
	}  

	$channel['legend'] = array('Received', 'Opened');
	$channel['data1'] = $channel['actual']['received'];
	$channel['data2'] = $channel['actual']['Opened'];
	
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph3_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT agency.AgencyID, agency.AgencyShortName, sum(TotalIN) as TotalIn, sum(TotalOUT) as TotalOut, sum(TotalIN)/sum(TotalOUT) as Ratio FROM 
				(
					SELECT B1.AgencyID, 0 AS TotalIN, Count(*) as TotalOUT
							FROM complaints
							JOIN users on users.UserID = complaints.UserID
							JOIN agency_branches B1 ON B1.AgencyBranchID = users.AgencyBranchID
							$querystring AND complaints.ComplaintStatusID <> 6	 					
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)
				UNION 
				(
					SELECT B1.AgencyID, Count(*) as TotalIN, 0 AS TotalOUT
							FROM complaints
							JOIN agency_branches B1 ON B1.AgencyBranchID = complaints.AgencyBranchID
							$querystring  AND complaints.ComplaintStatusID <> 6
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)
							)
				) TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				GROUP BY agency.AgencyID";

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Ratio=='') {$Ratio =0;} 
		$channel['data'][] = $Ratio;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Total In'][] = $TotalIn;
		$channel['actual']['Total Out'][] = $TotalOut;		
	}  

	$channel['legend'] = array('Total In', 'Total Out');
	$channel['data1'] = $channel['actual']['Total In'];
	$channel['data2'] = $channel['actual']['Total Out'];	

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph4_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT TEMP.Average, TotalTime, TotalComplaints, agency.AgencyShortName,agency.AgencyID  from
				(
					SELECT B2.AgencyID, avg(DATEDIFF(ResolutionDate, SubmissionDate)) AS Average,
					sum(DATEDIFF(ResolutionDate, SubmissionDate)) AS TotalTime, count(*) as TotalComplaints					
					FROM complaints 
					LEFT JOIN agency_branches B2 ON B2.AgencyBranchID = complaints.AgencyBranchID
					$querystring AND ComplaintStatusID = 5
					GROUP BY B2.AgencyID
					) AS TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				";
				
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Average=='') {$Average =0;}
		$channel['data'][] = $Average;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Total Time'][] = $TotalTime;
		$channel['actual']['Total Complaints Resolved'][] = $TotalComplaints;		
	}  

	$channel['legend'] = array('Total Time', 'Total Complaints Resolved');
	$channel['data1'] = $channel['actual']['Total Time'];
	$channel['data2'] = $channel['actual']['Total Complaints Resolved'];	

	$rss = $channel; 
	$json = json_encode($rss);	
	
	return $json;
}

function graph5_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT TEMP.Average, TotalTime, TotalComplaints, agency.AgencyShortName,agency.AgencyID  from
				(
					SELECT B2.AgencyID, avg(DATEDIFF(DateOpened, SubmissionDate)) AS Average, 
					sum(DATEDIFF(DateOpened, SubmissionDate)) AS TotalTime, count(*) as TotalComplaints
					FROM complaints 
					LEFT JOIN agency_branches B2 ON B2.AgencyBranchID = complaints.AgencyBranchID
					$querystring AND ComplaintStatusID <> 1 AND ComplaintStatusID <> 6
					GROUP BY B2.AgencyID
					) AS TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				";

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Average=='') {$Average =0;}
		$channel['data'][] = $Average;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Total Time'][] = $TotalTime;
		$channel['actual']['Total Complaints'][] = $TotalComplaints;		
	}  

	$channel['legend'] = array('Total Time', 'Total Complaints');
	$channel['data1'] = $channel['actual']['Total Time'];
	$channel['data2'] = $channel['actual']['Total Complaints'];

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph6_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) between '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT TEMP.Total,agency.AgencyShortName,agency.AgencyID  from
				(
					SELECT B2.AgencyID, Count(*) AS Total FROM complaints 
					LEFT JOIN agency_branches B2 ON B2.AgencyBranchID = complaints.AgencyBranchID
					JOIN agency ON agency.AgencyID = B2.AgencyID
					$querystring AND ComplaintStatusID = 5 AND DATEDIFF(ResolutionDate, SubmissionDate) <= ComplaintResolutionDays
					GROUP BY B2.AgencyID
					) AS TEMP
					RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				";
				
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel['data'][] = $Total;
		$channel['label'][] = $AgencyShortName;
	//	$channel['actual'][$PreviousPeriod][] = $PreviousData;
	//	$channel['actual'][$CurrentPeriod][] = $CurentData;		
	}  

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph7_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring1 = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";	
		$querystring2 = " WHERE YEAR(complaints.ResolutionDate) = '$Year' ";
	} else if ($id == 2)
	{
		$querystring1 = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";
		$querystring2 = " WHERE YEAR(complaints.ResolutionDate) = '$Year' AND QUARTER(complaints.ResolutionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring1 = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";
		$querystring2 = " WHERE YEAR(complaints.ResolutionDate) = '$Year' AND MONTH(complaints.ResolutionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring1 = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
		$querystring2 = " WHERE YEAR(complaints.ResolutionDate) = '$Year' AND WEEK(complaints.ResolutionDate) = '$Week' ";
	} else if ($id == 5)
	{
		$querystring1 = " WHERE DATE(complaints.SubmissionDate) between '$StartDate' AND '$EndDate' ";	
		$querystring2 = " WHERE DATE(complaints.ResolutionDate) between '$StartDate' AND '$EndDate' ";	
	}

	$sql = "SELECT TEMP2.*, AgencyShortName FROM
				(
				SELECT AgencyID, Sum(ResolvedTotal)/Sum(ReceivedTotal) AS Total, Sum(ResolvedTotal) AS ResolvedTotal,  Sum(ReceivedTotal) AS ReceivedTotal 
				FROM
				(
				SELECT B2.AgencyID, Count(*) AS ReceivedTotal, 0 AS ResolvedTotal FROM complaints 
								LEFT JOIN agency_branches B2 ON B2.AgencyBranchID = complaints.AgencyBranchID
								JOIN agency ON agency.AgencyID = B2.AgencyID				
								$querystring1 AND ComplaintStatusID <> 6
								GROUP BY B2.AgencyID
				UNION
				(
				SELECT B2.AgencyID, 0 AS ReceivedTotal, Count(*) AS ResolvedTotal FROM complaints 
								LEFT JOIN agency_branches B2 ON B2.AgencyBranchID = complaints.AgencyBranchID
								JOIN agency ON agency.AgencyID = B2.AgencyID				
								$querystring2 AND ComplaintStatusID = 5
								GROUP BY B2.AgencyID
				)
				) TEMP1 
				GROUP BY AgencyID
				) TEMP2
				RIGHT JOIN agency ON agency.AgencyID = TEMP2.AgencyID
				";

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel['data'][] = $Total;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Resolved Total'][] = $ResolvedTotal;
		$channel['actual']['Received Total'][] = $ReceivedTotal;		
	}  

	$channel['legend'] = array('Resolved Total', 'Received Total');
	$channel['data1'] = $channel['actual']['Resolved Total'];
	$channel['data2'] = $channel['actual']['Received Total'];

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph8_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT agency.AgencyID, agency.AgencyShortName, sum(submitted) As TotalComplaints, sum(relevant) AS Relevant, sum(relevant)/sum(submitted)*100 as Ratio FROM 
				(
					SELECT B1.AgencyID, 0 AS submitted, Count(*) as relevant
							FROM complaints
							JOIN agency_branches B1 ON B1.AgencyBranchID = complaints.AgencyBranchID
							$querystring AND ComplaintStatusID <> 6	AND NotRelevant = 0			
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)
				UNION 
				(
					SELECT B1.AgencyID, Count(*) as submitted, 0 AS relevant
							FROM complaints
							JOIN agency_branches B1 ON B1.AgencyBranchID = complaints.AgencyBranchID
							$querystring AND ComplaintStatusID <> 6
							GROUP BY B1.AgencyID, YEAR(complaints.SubmissionDate)
							)
				) TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				GROUP BY agency.AgencyID";

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Ratio=='') {$Ratio =0;} 
		$channel['data'][] = $Ratio;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Total Complaints'][] = $TotalComplaints;
		$channel['actual']['Relevant'][] = $Relevant;		
	}  

	$channel['legend'] = array('Total Complaints', 'Relevant');
	$channel['data1'] = $channel['actual']['Total Complaints'];
	$channel['data2'] = $channel['actual']['Relevant'];

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph9_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$AgencyArray = getAgencies($connection);
	$CountyArray = getCounties($connection);
	$DisplayArray = array(0=>'False', 1=>'True');
	$Option = 'county';
	$channel = array();
	
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$ActiveCountyArray = array();
	/*
	$sql = "SELECT * FROM 
			(SELECT Count(*) as Total, complaints.IncidentCountyID AS CountyID, branch.AgencyID FROM complaints
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID
				$querystring AND complaints.CountyID <> 0
				AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY complaints.CountyID, branch.AgencyID
				) Temp
				RIGHT JOIN county On county.CountyID = Temp.CountyID
				";
	*/
	$sql = "SELECT TEMP.Total,CountyID, agency.AgencyID  from
				(
				SELECT Count(*) as Total, 
				CASE 
                WHEN complaints.CountyID IS NULL THEN 48
                WHEN complaints.CountyID = 0 THEN 48
				ELSE complaints.CountyID
				END AS CountyID 
				,agency.AgencyID FROM complaints
				JOIN profiles ON profiles.ProfileID = complaints.ProfileID
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID
				RIGHT JOIN agency On agency.AgencyID = branch.AgencyID
				$querystring  AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY CountyID, agency.AgencyShortName
				) AS TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID	
				WHERE CountyID is not null			
				ORDER BY AgencyID";
	//echo $sql; exit;

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();      
	//print_r($CountyArray) ; exit;               
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$myarray[$CountyID][$AgencyID] = $Total;
		$ActiveCountyArray[$CountyID] = isset($CountyArray[$CountyID]) ? $CountyArray[$CountyID] : 48;
	}  

	foreach ($ActiveCountyArray AS $Ckey => $Cvalue)
	{
		$channel['labels'][] =$Cvalue;
	}

	foreach ($AgencyArray AS $Akey => $Avalue)
	{
		$dataarray = array();
		foreach ($ActiveCountyArray AS $Ckey => $Cvalue)
		{
			//echo "5 </br>";
			$Total = "0";
			if (isset($myarray[$Ckey][$Akey]))
			{
				$Total = $myarray[$Ckey][$Akey];
			}
			$dataarray[] = $Total;
		}	
		$channel['datasets'][] = array(
							'label' => $Avalue['AgencyName'],
							'fillColor' => $Avalue['ColourCode'],
							'strokeColor'=> $Avalue['ColourCode'],
							'legendTemplate' => '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\">jk</span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
							'data'=>$dataarray
							);	
	}

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph10_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$AgencyArray = getAgencies($connection);
	$AgeArray = getagecategory($connection);
	$DisplayArray = array(0=>'False', 1=>'True');
	$Option = 'county';
	$myarray = array();
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT TEMP.Total,AgeCategoryID, agency.AgencyID  from
				(
				SELECT Count(*) as Total, 
				CASE 
                WHEN profiles.AgeCategoryID IS NULL THEN 7
                WHEN profiles.AgeCategoryID = 0 THEN 7
				ELSE profiles.AgeCategoryID
				END AS AgeCategoryID 
				,agency.AgencyID FROM complaints
				JOIN profiles ON profiles.ProfileID = complaints.ProfileID
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID
				RIGHT JOIN agency On agency.AgencyID = branch.AgencyID
				$querystring AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY AgeCategoryID, agency.AgencyShortName
				) AS TEMP
				RIGHT JOIN agency ON agency.AgencyID = TEMP.AgencyID
				
				ORDER BY AgencyID
				";
	//echo $sql; exit;
				//WHERE AgeCategoryID <> 0 AND AgeCategoryID is not null 
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$myarray[$AgeCategoryID][$AgencyID] = $Total;
	}  

	foreach ($AgeArray AS $Ckey => $Cvalue)
	{
		$channel['labels'][] =$Cvalue;
	}

	foreach ($AgencyArray AS $Akey => $Avalue)
	{

		//$channel['datasets']['data'] = array();
		$dataarray = array();
		foreach ($AgeArray AS $Ckey => $Cvalue)
		{
			$Total = "0";
			if (isset($myarray[$Ckey][$Akey]))
			{
				$Total = $myarray[$Ckey][$Akey];
			}
			$dataarray[] = $Total;
		}	
		$channel['datasets'][] = array('label' => $Avalue['AgencyName'],
							'fillColor' => $Avalue['ColourCode'],
							'strokeColor'=> $Avalue['ColourCode'],
							'data'=>$dataarray
							);	

	}
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph10b_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}
	/*
	$sql = "SELECT count(*) as Total, agecategory.AgeCategoryID, AgeCategoryName FROM 
				(
				SELECT ComplaintID, 
				CASE 
                WHEN profiles.AgeCategoryID IS NULL THEN 7
                WHEN profiles.AgeCategoryID = 0 THEN 7
				ELSE profiles.AgeCategoryID
				END AS AgeCategoryID
				 FROM complaints 
				JOIN profiles ON profiles.ProfileID = complaints.ProfileID
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID
				$querystring
				AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				) temp 
				RIGHT JOIN agecategory On agecategory.AgeCategoryID = temp.AgeCategoryID
				GROUP BY AgeCategoryID
				";
	*/
	$sql = "SELECT Total, agecategory.AgeCategoryID, AgeCategoryName 
			FROM 
			( 
				SELECT count(*) as Total, AgeCategoryID FROM 
				(
					SELECT ComplaintID, CASE WHEN profiles.AgeCategoryID IS NULL THEN 7 WHEN profiles.AgeCategoryID = 0 THEN 7 
					ELSE profiles.AgeCategoryID END AS AgeCategoryID 
					FROM complaints JOIN profiles ON profiles.ProfileID = complaints.ProfileID 
					JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
					$querystring 
					AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				) t1
				GROUP BY AgeCategoryID 
			) temp 
			RIGHT JOIN agecategory On agecategory.AgeCategoryID = temp.AgeCategoryID ";
	//echo $sql; exit;
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel[] = array(	'label' => $AgeCategoryName,
										'color' => get_colour(),
										'value'=>$Total
										);	
	}  
	
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph11_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$AgencyArray = getAgencies($connection);
	$GenderArray = getgender($connection);
	$DisplayArray = array(0=>'False', 1=>'True');
	$Option = 'county';
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}
	/*
	$sql = "SELECT count(*) as Total, GenderID, branch.AgencyID FROM complaints
				JOIN profiles ON profiles.ProfileID = complaints.ProfileID
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
				$querystring 
				AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY GenderID, branch.AgencyID";
		*/		
	$sql = "SELECT count(*) As Total, AgencyID, GenderID From
			(
			SELECT ComplaintID, branch.AgencyID, 
			CASE WHEN profiles.GenderID IS NULL THEN 4 
			WHEN profiles.GenderID = 0 THEN 4 
			ELSE profiles.GenderID END AS GenderID 
			FROM complaints
			JOIN profiles ON profiles.ProfileID = complaints.ProfileID
			JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
			$querystring
			AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
			) AS temp
			GROUP BY AgencyID, GenderID";
				
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$myarray[$GenderID][$AgencyID] = $Total;
	}  
	
	foreach ($GenderArray AS $Ckey => $Cvalue)
	{
		$channel['labels'][] =$Cvalue;
	}
	
	foreach ($AgencyArray AS $Akey => $Avalue)
	{
	
		//$channel['datasets']['data'] = array();
		$dataarray = array();
		foreach ($GenderArray AS $Ckey => $Cvalue)
		{
			$Total = "0";
			if (isset($myarray[$Ckey][$Akey]))
			{
				$Total = $myarray[$Ckey][$Akey];
			}
			$dataarray[] = $Total;
		}	
		$channel['datasets'][] = array('label' => $Avalue['AgencyName'],
							'fillColor' => $Avalue['ColourCode'],
							'strokeColor'=> $Avalue['ColourCode'],
							'data'=>$dataarray
							);	
	
	}
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph11b_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}
	
	$sql = "SELECT count(*) As Total, temp.GenderID, GenderName From
			(
			SELECT ComplaintID, 
			CASE WHEN profiles.GenderID IS NULL THEN 4 
			WHEN profiles.GenderID = 0 THEN 4 
			ELSE profiles.GenderID END AS GenderID 
			FROM complaints
			JOIN profiles ON profiles.ProfileID = complaints.ProfileID
			JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
			$querystring 
			AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
			) AS temp
			RIGHT JOIN gender On gender.GenderID = temp.GenderID
			GROUP BY gender.GenderID, GenderName";
	
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel[] = array(	'label' => $GenderName,
										'color' => rand_color(),
										'value'=>$Total
										);	
	}  
	
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph12_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$AgencyArray = getAgencies($connection);
	$NatureArray = getnatureofcomplaint($connection);
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}
	
	$sql = "SELECT count(*) as Total, NatureofComplaintID, branch.AgencyID 
			FROM complaints
				JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
				$querystring AND NatureofComplaintID <> 0  
				AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY NatureofComplaintID, branch.AgencyID
				";
	
	$myarray = array();
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$myarray[$NatureofComplaintID][$AgencyID] = $Total;
	}  
	
	foreach ($NatureArray AS $Ckey => $Cvalue)
	{
		$channel['labels'][] =$Cvalue;
	}
	
	foreach ($AgencyArray AS $Akey => $Avalue)
	{
	
		//$channel['datasets']['data'] = array();
		$dataarray = array();
		foreach ($NatureArray AS $Ckey => $Cvalue)
		{
			$Total = "0";
			if (isset($myarray[$Ckey][$Akey]))
			{
				$Total = $myarray[$Ckey][$Akey];
			}
			$dataarray[] = $Total;
		}	
		$channel['datasets'][] = array('label' => $Avalue['AgencyName'],
							'fillColor' => $Avalue['ColourCode'],
							'strokeColor'=> $Avalue['ColourCode'],
							'data'=>$dataarray
							);	
		
	}
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph12b_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}
	/*
	$sql = "SELECT Count(*) as Total, natureofcomplaint.NatureofComplaintID, NatureofComplaintName FROM complaints
				RIGHT JOIN natureofcomplaint On natureofcomplaint.NatureofComplaintID = complaints.NatureofComplaintID
				$querystring
				AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
				GROUP BY natureofcomplaint.NatureofComplaintID, NatureofComplaintName
				";
	*/
	$sql = "SELECT Total, natureofcomplaint.NatureofComplaintID, NatureofComplaintName 
			FROM 
			(
			SELECT Count(*) as Total, NatureofComplaintID
			FROM complaints  
			JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID 
			$querystring 
			AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
			GROUP BY NatureofComplaintID
			) as temp
			RIGHT JOIN natureofcomplaint On natureofcomplaint.NatureofComplaintID = temp.NatureofComplaintID";

	//echo $sql; exit;
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel[] = array(	'label' => $NatureofComplaintName,
										'color' => rand_color(),
										'value'=>$Total
										);	
	}  
	
	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph13b_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND QUARTER(complaints.SubmissionDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND MONTH(complaints.SubmissionDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE YEAR(complaints.SubmissionDate) = '$Year' AND WEEK(complaints.SubmissionDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(complaints.SubmissionDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT TEMP.Total, agency.AgencyID, AgencyShortName, ColourCode FROM
				(
				SELECT Count(*) as Total, branch.AgencyID FROM complaints
					JOIN agency_branches branch on branch.AgencyBranchID = complaints.AgencyBranchID			
					$querystring
					AND ComplaintStatusID <> 6 AND ComplaintStatusID <> 0
					GROUP BY branch.AgencyID           
				) TEMP
				RIGHT JOIN agency On agency.AgencyID = TEMP.AgencyID
				";
	//echo $sql;							
	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel[] = array(	'label' => $AgencyShortName,
										'color' => $ColourCode,
										'value'=>$Total,
										'labelColor' => 'white',
										'labelFontSize' => '16'
										);	
	}  

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}

function graph14_data($id, $Year, $Quarter, $Month, $Week, $StartDate, $EndDate, $connection)
{
	$channel = array();
	if ($id == 1)
	{
		$querystring = " WHERE Year(log.CreatedDate) = '$Year' ";		
	} else if ($id == 2)
	{
		$querystring = " WHERE Year(log.CreatedDate) = '$Year' AND QUARTER(log.CreatedDate) = '$Quarter' ";			
	} else if ($id == 3)
	{
		$querystring = " WHERE Year(log.CreatedDate) = '$Year' AND MONTH(log.CreatedDate) = '$Month' ";		
	} else if ($id == 4)
	{
		$querystring = " WHERE Year(log.CreatedDate) = '$Year' AND WEEK(log.CreatedDate) = '$Week' ";		
	} else if ($id == 5)
	{
		$querystring = " WHERE DATE(log.CreatedDate) BETWEEN '$StartDate' AND '$EndDate' ";		
	}

	$sql = "SELECT Temp.AgencyID, sum(Active) AS Active,  sum(Total) AS Total, AgencyShortName FROM 
				(
				select B1.AgencyID, count(distinct(log.UserID)) AS Active, 0 As Total FROM login_log log
				Join users ON users.userID = log.UserID
				JOIN agency_branches B1 ON B1.AgencyBranchID = users.AgencyBranchID
				$querystring
				AND Successfull = 1 
				GROUP BY B1.AgencyID
                UNION
                (
					SELECT B1.AgencyID, 0 AS Active, count(*) AS Total FROM users 
                    JOIN agency_branches B1 ON B1.AgencyBranchID = users.AgencyBranchID
                    GROUP BY B1.AgencyID
                )
				) Temp
				RIGHT JOIN agency ON agency.AgencyID = Temp.AgencyID
                GROUP BY AgencyID";

	$s_model = $connection->createCommand($sql);
	$s_data = $s_model->queryAll();                      
	foreach ($s_data AS $key => $row)
	{  
		extract($row);
		if ($Total=='') {$Total =0;}
		$channel['data'][] = $Total;
		$channel['label'][] = $AgencyShortName;
		$channel['actual']['Active'][] = $Active;
		$channel['actual']['Total'][] = $Total;
	}  

	$channel['legend'] = array('Active', 'Total');
	$channel['data1'] = $channel['actual']['Active'];
	$channel['data2'] = $channel['actual']['Total'];

	$rss = $channel; 
	$json = json_encode($rss);
	return $json;
}
?>