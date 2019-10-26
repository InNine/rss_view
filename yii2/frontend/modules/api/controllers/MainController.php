<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2019
 * Time: 5:36
 */

namespace frontend\modules\api\controllers;

use frontend\base\BaseRESTController;

class MainController extends BaseRESTController
{

    public function actionIndex()
    {
        return [
            'status' => 'ok',
            'message' => 'API is working :)'
        ];
    }
}