<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * homepage. Actually, this is only one route for rendering, API is in frontend/modules/api
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
