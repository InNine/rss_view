<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.10.2019
 * Time: 14:23
 */

namespace frontend\modules\api\controllers;


use common\domain\user\forms\LoginForm;
use common\domain\user\forms\RegisterForm;
use common\domain\user\services\AuthService;
use frontend\base\BaseRESTController;

class AuthController extends BaseRESTController
{

    public function actionLogin()
    {
        $form = new LoginForm();
        if ($form->loadFromPostAndValidate()) {
            return (new AuthService())->login($form->getUser());
        }
        return [
            'success' => false,
            'message' => implode(', ', $form->getErrorSummary(false))
        ];
    }

    public function actionRegister()
    {
        $form = new RegisterForm();
        if ($form->loadFromPostAndValidate()) {
            return (new AuthService())->registerForm($form);
        }
        return [
            'success' => false,
            'message' => implode(', ', $form->getErrorSummary(false))
        ];
    }
}