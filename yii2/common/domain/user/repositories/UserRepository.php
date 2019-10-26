<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.2019
 * Time: 12:06
 */

namespace common\domain\user\repositories;

use common\base\BaseRepository;
use common\domain\user\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UserRepository extends BaseRepository
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery(): ActiveQuery
    {
        return User::find();
    }

    /**
     * @param $username
     * @return User|null
     */
    public function getOneByUsername(string $username): ?ActiveRecord
    {
        return $this->getQuery()->andWhere(['username' => $username])->one();
    }

    /**
     * @param User $model
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @return User
     * @throws \yii\base\Exception
     */
    public function save($model, bool $runValidation = true, ?array $attributeNames = null): ActiveRecord
    {
        if ($model->isNewRecord) {
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->status = User::STATUS_ACTIVE;
            $model->created_at = time();
        }
        $model->created_at = $model->updated_at = time();
        return parent::save($model, $runValidation, $attributeNames);
    }

}