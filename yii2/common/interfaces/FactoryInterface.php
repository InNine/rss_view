<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 13:05
 */

namespace common\interfaces;


interface FactoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);
}