<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.10.2019
 * Time: 1:03
 */

namespace common\domain\author\repositories;

use common\base\BaseRepository;
use common\domain\author\models\Author;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AuthorRepository
 * @package common\domain\author\repositories
 */
class AuthorRepository extends BaseRepository
{
    /**
     * @return ActiveQuery
     */
    public function getQuery(): ActiveQuery
    {
        return Author::find();
    }

    /**
     * @param $name
     * @param $link
     * @return Author|null|ActiveRecord
     */
    public function getOneByNameAndUrl($name, $link): ?Author
    {
        return $this->getQuery()->andWhere(['name' => $name, 'url' => $link])->one();
    }
}