<?php
/**
 * Created date: 07.11.2017 14:34
 * @author yamilramilev <yamilramilev@gmail.com>
 */
namespace frontend\modules\api;

class Module extends \yii\base\Module
{
    public $defaultRoute = '/main/index';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';
}