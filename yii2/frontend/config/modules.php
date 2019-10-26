<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.10.2019
 * Time: 15:39
 */

$modules = [
    'api' => [
        'class' => \frontend\modules\api\Module::class
    ]
];
/* gii to generate models easy and fast ;) */
if (YII_ENV_DEV) {
   $modules['gii'] = [
       'class' => \yii\gii\Module::class
    ];
}
return $modules;