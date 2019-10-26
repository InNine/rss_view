<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 0:52
 */

namespace common\base;


use common\domain\user\models\User;
use common\interfaces\RepositoryInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * base repository for commons, removing duplicate code
 * Class BaseRepository
 * @package common\services
 */
abstract class BaseRepository implements RepositoryInterface
{

    /**
     * @return ActiveQuery
     */
    public function getQuery(): ActiveQuery
    {
        // Implement getQuery() method in child nodes
    }

    /**
     * default getOne
     * @param int $id
     * @return ActiveRecord|null
     */
    public function getOne(int $id): ?ActiveRecord
    {
        return $this->getQuery()->andWhere(['id' => $id])->one();
    }

    /**
     * @param null|int $limit
     * @param null|int $offset
     * @return array
     */
    public function getAll(?int $limit = null, ?int $offset = null): array
    {
        return $this->getQuery()->limit($limit)->offset($offset)->all();
    }


    /**
     * @param User $model
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @return ActiveRecord
     * @throws \Exception
     */
    public function save($model, bool $runValidation = true, ?array $attributeNames = null): ActiveRecord
    {
        if (!$model->save($runValidation, $attributeNames)) {
            throw new \Exception(implode($model->getErrorSummary(false)));
        }
        return $model;
    }

}