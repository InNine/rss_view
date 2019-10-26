<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 0:43
 */

namespace common\base;

use common\interfaces\FactoryInterface;
use yii\db\ActiveRecord;

/**
 * Simply throw model that you need
 * Class BaseFactory
 * @package common\services
 */
abstract class BaseFactory implements FactoryInterface
{
    /** @var ActiveRecord */
    public $model;

    /**
     * @param array $attributes
     * @return ActiveRecord
     */
    public function create(array $attributes): ActiveRecord
    {
        foreach (array_intersect(array_keys($attributes), $this->model->attributes()) as  $key) {
            $this->model->$key = $attributes[$key];
        }
        return $this->model;
    }
}