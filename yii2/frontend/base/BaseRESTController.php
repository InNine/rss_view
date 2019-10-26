<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2019
 * Time: 5:25
 */

namespace frontend\base;



use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class BaseRESTController extends Controller
{

    public function init()
    {
        parent::init();
        // Disable sessions
        \Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Auth options
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['register','login'],
        ];

        return $behaviors;

    }

}