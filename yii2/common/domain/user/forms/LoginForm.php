<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 11:58
 */

namespace common\domain\user\forms;


use common\domain\user\models\User;
use common\domain\user\repositories\UserRepository;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    private $user;

    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array|null $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $this->user = (new UserRepository())->getOneByUsername($this->username);
            if (!$this->user || !\Yii::$app->security->validatePassword($this->password, $this->user->password_hash)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function loadFromPostAndValidate(): bool
    {
        $post = \Yii::$app->request->post();
        if (!key_exists('username', $post) || !key_exists('password', $post)) {
            $this->addError('username', 'Fill all fields!');
            return false;
        }
        $this->username = $post['username'];
        $this->password = $post['password'];
        return $this->validate();
    }

}