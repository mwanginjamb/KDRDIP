<?php
namespace backend\modules\api\resources;

use app\models\Projects;

class ProjectResource extends Projects 
{
    public function fields()
    {
        return ['ProjectID', 'ProjectName', 'CountyID', 'SubCountyID', 'WardID'];
    }

    public function extraFields()
    {
        return [
            'fy'
        ];
    }
}