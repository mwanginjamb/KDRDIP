<?php

namespace backend\controllers;

use Yii;
use yii\base\BootstrapInterface;
use app\models\UserGroupRights;

/*
/* The base class that you use to retrieve the settings from the database
*/

class rights implements BootstrapInterface {

    private $db;

    public function __construct() {
        $this->db = Yii::$app->db;
    }

    /**
    * Bootstrap method to be called during application bootstrap stage.
    * Loads all the settings into the Yii::$app->params array
    * @param Application $app the application currently running
    */

    public function bootstrap($app) 
	{
		if (isset(Yii::$app->user->identity))
		{
			$id = Yii::$app->user->identity->UserID;
		} else
		{
			$id = 0;
		}
		
		
		$sql = "SELECT pages.PageID as FormID, COALESCE(`View`, 0) as `View`,
					COALESCE(`Edit`, 0) as `Edit`,
					COALESCE(`Create`, 0) as `Insert`,
					COALESCE(`Delete`, 0) as `Delete`,
					COALESCE(`Post`, 0) as `Post`
					FROM pages
					LEFT JOIN usergrouprights ON usergrouprights.PageID = pages.PageID
					AND UserGroupID = (SELECT UserGroupID FROM users WHERE UserID = '$id')
				";
		$model = UserGroupRights::findBySql($sql)->asArray()->all();
		
		$Rights = [];
		foreach ($model as $key => $row)
		{
			extract($row);
			$Rights[$FormID] = array(	'View'=>$View, 
										'Edit' => $Edit,
										'Insert' => $Insert,
										'Delete' => $Delete,
										'Post' => $Post
									);
		}
		Yii::$app->params['rights'] = $Rights;
    }
}