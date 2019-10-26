<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 1:05
 */

namespace common\domain\author\services;

use common\base\BaseFactory;
use common\domain\author\models\Author;

/**
 * Class AuthorFactory
 * @package common\domain\author\services
 */
class AuthorFactory extends BaseFactory
{
    /**
     * AuthorFactory constructor.
     */
    public function __construct()
    {
        $this->model = new Author();
    }
}