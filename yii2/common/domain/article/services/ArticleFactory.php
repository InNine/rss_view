<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 0:42
 */

namespace common\domain\article\services;

use common\domain\article\models\Article;
use common\base\BaseFactory;

class ArticleFactory extends BaseFactory
{
    /**
     * UserFactory constructor.
     */
    public function __construct()
    {
        $this->model = new Article();
    }
}