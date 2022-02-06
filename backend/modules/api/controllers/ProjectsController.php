<?php

namespace backend\modules\api\controllers;

use backend\modules\api\resources\ProjectResource;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;


class ProjectsController extends \yii\rest\ActiveController
{
    public $modelClass = ProjectResource::class;

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviours['cors'] = [
            'class' => Cors::class,
            'cors' => [
                //  methods to allow
                'Access-Control-Request-Method' => ['POST', 'PUT', 'GET','DELETE'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => false,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];


        return $behaviors;
    }
}
