<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 16:50
 */

namespace frontend\modules\api\controllers;


use frontend\base\BaseRESTController;
use frontend\modules\api\services\ArticleService;

class ArticleController extends BaseRESTController
{
    public function actionGetList($page = 1)
    {
        return (new ArticleService())->getArticleData($page);
    }
}