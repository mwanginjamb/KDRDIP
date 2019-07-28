<?php
use app\models\Agency; 

function getselectedparameters($table,$receivedHash1, $Fields, $agencyonly)
{
	$connection = \Yii::$app->db;  
        
	$channel = array();
	$receivedHash = 'e9a61ea21f0f774bead3d8eef16d8e7f056150e1d3acff6ea0b61dd9cbf370b282e5352cd74125441535272babf520b070f7cdc7b0f9761e54671cf6d0e2be9a';
	if ($receivedHash!='')
	{
		$Agency = Agency::find()->where(['Hash' => $receivedHash])->one();
		if (!$Agency)
		{
			$channel[] = array(
								"Result"=>'01',
								"Message"=>'Invalid Authentication Details'
								);                
		} else
		{
			$wherestr = '';
			if ($agencyonly==1)
			{
				$AgencyID = $Agency->AgencyID;
				$wherestr = " WHERE AgencyID = $AgencyID";	
			}
			$sql = "SELECT * FROM $table $wherestr";
			if ($model = $connection->createCommand($sql)) 
			{                              
				$results = $model->queryAll();                    
				foreach ($results AS $key => $row)
				{
					extract($row);
					$FieldString = array();
					foreach ($Fields AS $FieldID => $FiledName)
					{
						//echo "$FieldID => $FiledName </br>";
						//echo $row[$FiledName]."</br>";
						$FieldString[$FiledName] = $row[$FiledName];
					}
					//exit;
					$channel[] = $FieldString;
				}
			} else
			{
				$channel[] = array(
								"Result"=>'02',
								"Message"=>'System Error'
                                );
			}
		}
	} else
	{
            $channel[] = array(
								"Result"=>'01',
								"Message"=>'Invalid Authentication Details'
                                );
	}
	
	$rss = (object) array('jData'=>$channel);
	$json = json_encode($rss);
	return $json;         
}

function getparameters($table, $receivedHash1)
{
	$connection = \Yii::$app->db;  
        
	$channel = array();
	$receivedHash = 'e9a61ea21f0f774bead3d8eef16d8e7f056150e1d3acff6ea0b61dd9cbf370b282e5352cd74125441535272babf520b070f7cdc7b0f9761e54671cf6d0e2be9a';
	if ($receivedHash!='')
	{
		$Agency = Agency::find()->where(['Hash' => $receivedHash])->one();
		if (!$Agency)
		{
			$channel[] = array(
								"Result"=>'01',
								"Message"=>'Invalid Authentication Details'
								);                
		} else
		{
			$sql = "SELECT * FROM $table";
			if ($model = $connection->createCommand($sql)) 
			{                              
				$results = $model->queryAll();                    
				foreach ($results AS $key => $row)
				{
					extract($row);
					$channel[] = $row;
				}
			} else
			{
				$channel[] = array(
								"Result"=>'02',
								"Message"=>'System Error'
                                );
			}
		}
	} else
	{
            $channel[] = array(
								"Result"=>'01',
								"Message"=>'Invalid Authentication Details'
                                );
	}
	
	$rss = (object) array('jData'=>$channel);
	$json = json_encode($rss);
	return $json; 
}
?>