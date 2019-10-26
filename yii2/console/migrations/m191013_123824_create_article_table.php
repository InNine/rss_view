<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m191013_123824_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'parse_id' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'parse_updated_at' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'link' => $this->string()->null(),
            'title' => $this->string(255)->notNull(),
            'summary' => $this->text()->notNull(),
        ]);
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull()
        ]);
        $this->addForeignKey('fk_article_to_author', 'article', 'author_id', 'author', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_to_author', 'article');
        $this->dropTable('article');
        $this->dropTable('author');
    }
}
