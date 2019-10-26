<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 13:04
 */

namespace common\domain\user\services;


use common\domain\user\models\User;
use common\base\BaseFactory;

/**
 * Class UserFactory
 * @package common\domain\user\services
 */
class UserFactory extends BaseFactory
{
    /**
     * UserFactory constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

}