<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 12:14
 */

namespace common\domain\user\services;

use common\domain\user\forms\RegisterForm;
use common\domain\user\models\User;
use common\domain\user\repositories\UserRepository;
use Yii;

class AuthService
{
    /**
     * simple login, can be improved by rememberMe button (instead of 3600*24*30)
     * @param User $user
     * @return array
     */
    public function login(User $user): array
    {
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return [
                'success' => true,
                'token' => Yii::$app->user->identity->getAuthKey()
            ];
        }
        return [
            'success' => false,
            'message' => 'Fail to login, please try again'
        ];
    }

    /**
     * Register user and login. Returns access token
     * @param RegisterForm $form
     * @return array
     */
    public function registerForm(RegisterForm $form): array
    {
        /** @var User $user */
        $user = (new UserFactory())->create($form->getAttributes());
        try {
            $user->setPassword($form->password);
            $user = (new UserRepository())->save($user);
            return $this->login($user);

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}