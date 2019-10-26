<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.10.2019
 * Time: 15:20
 */

namespace console\controllers;

use console\services\MostFrequentWordsService;
use console\services\ParseService;
use yii\console\Controller;

class ParseController extends Controller
{

    public function actionIndex()
    {
        try {
            (new ParseService())->parse();
            (new MostFrequentWordsService())->addFrequentWords();
            echo 'Parse done';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }


    }
}