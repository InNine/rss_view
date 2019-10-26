<?php

namespace common\domain\article\models;

use common\domain\author\models\Author;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $parse_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $parse_updated_at
 * @property int $author_id
 * @property string $link
 * @property string $title
 * @property string $summary
 *
 * @property Author $author
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parse_id', 'created_at', 'updated_at', 'parse_updated_at', 'author_id', 'title', 'summary'], 'required'],
            [['created_at', 'updated_at', 'author_id'], 'integer'],
            [['summary', 'link'], 'string'],
            [['parse_id', 'parse_updated_at', 'title'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parse_id' => 'Parse ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'parse_updated_at' => 'Parse Updated At',
            'author_id' => 'Author ID',
            'link' => 'Link',
            'title' => 'Title',
            'summary' => 'Summary',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
