<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 0:49
 */

namespace common\domain\article\repositories;

use common\base\BaseRepository;
use common\domain\article\models\Article;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ArticleRepository extends BaseRepository
{
    /**
     * @return ActiveQuery
     */
    public function getQuery(): ActiveQuery
    {
        return Article::find();
    }

    /**
     * @param string $id
     * @return null|Article|ActiveRecord
     */
    public function getOneByParseId(string $id): ?Article
    {
        return $this->getQuery()->andWhere(['parse_id' => $id])->one();
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array|Article[]
     */
    public function getAllText(?int $limit = null, ?int $offset = null): array
    {
        return $this->getQuery()->limit($limit)->offset($offset)->select(['title', 'summary'])->all();
    }

    /**
     * @param \common\domain\user\models\User|ActiveRecord $model
     * @param bool $runValidation
     * @param array|null $attributeNames
     * @return ActiveRecord
     * @throws \Exception
     */
    public function save($model, bool $runValidation = true, ?array $attributeNames = null): ActiveRecord
    {
        if ($model->isNewRecord) {
            $model->created_at = time();
        }
        $model->updated_at = time();
        return parent::save($model, $runValidation, $attributeNames);
    }

    /**
     * @return ActiveQuery
     */
    public function getQueryForList(): ActiveQuery
    {
        return $this->getQuery()
            ->select(['title', 'link', 'summary AS description']); //need change name of summary bcs of js deprecated symbol

    }
    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return Article[]
     */
    public function getAllForList(?int $limit = null, ?int $offset = null): array
    {
        return $this->getQueryForList()
            ->asArray()
            ->limit($limit)
            ->offset($offset)
            ->all();
    }

    public function getCountForList()
    {
        return $this->getQueryForList()->count();
    }

}