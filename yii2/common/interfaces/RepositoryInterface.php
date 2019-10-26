<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 12:52
 */

namespace common\interfaces;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getQuery(): ActiveQuery;

    /**
     * @param int $id
     * @return mixed
     */
    public function getOne(int $id): ?ActiveRecord;

    /**
     * @param null|int $limit
     * @param null|int $offset
     * @return mixed
     */
    public function getAll(?int $limit = null, ?int $offset = null): array;

    /**
     * @param $model
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @return ActiveRecord
     */
    public function save($model, bool $runValidation = true, ?array $attributeNames = null): ActiveRecord;
}