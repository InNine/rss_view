<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 12:22
 */

namespace common\domain\user\forms;


use common\domain\user\models\User;
use yii\base\Model;

class RegisterForm extends Model
{

    public $username;
    public $password;
    public $repeat_password;

    public function rules()
    {
        return [
            [['username', 'password', 'repeat_password'], 'required'],
            ['username', 'string', 'max' => 255],
            [['password', 'repeat_password'], 'string', 'min' => 6],
            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'username should be unique'],
            [['password', 'repeat_password'], 'checkEqual'],
        ];
    }

    /**
     * simple check passwords equal and add error if not
     * @param $attribute
     * @param $params
     */
    public function checkEqual($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password != $this->repeat_password) {
                $this->addError($attribute, 'Passwords should be equal');
            }
        }
    }

    public function loadFromPostAndValidate()
    {
        $post = \Yii::$app->request->post();
        if (!key_exists('username', $post) || !key_exists('password', $post) || !key_exists('repeat_password', $post)) {
            $this->addError('username', 'Fill all fields!');
            return false;
        }
        $this->username = $post['username'];
        $this->password = $post['password'];
        $this->repeat_password = $post['repeat_password'];
        return $this->validate();
    }
}